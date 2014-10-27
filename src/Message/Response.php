<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use Omnipay\ACHWorks\ACHReturnRecord;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

/**
 * ACHWorks Response
 */
class Response extends AbstractResponse implements RedirectResponseInterface
{
    private $StatusOK = false;
    private $ACHWorksResponseMessage = "";
    private $VALID_RESPONSE = 200;
    private $ACHReturnRecords = null;
    private $ACHHistReturnsResultTest =
        '<GetACHReturnsResponse xmlns="http://achworks.com/">
         <GetACHReturnsResult>
         <SSS>string</SSS>
         <LocID>string</LocID>
         <Status>string</Status>
         <Details>string</Details>
         <TotalNumRecords>2</TotalNumRecords>
         <ReturnDateFrom>dateTime</ReturnDateFrom>
         <ReturnDateTo>dateTime</ReturnDateTo>
         <TotalNumErrors>int</TotalNumErrors>
         <Errors>
         <string>string</string>
         <string>string</string>
         </Errors>
         <ACHReturnRecords>
           <ACHReturnRecord>
              <SSS>SS1</SSS>
              <LocID>LOC1</LocID>
              <SourceFile>Source1</SourceFile>
              <FrontEndTrace>string</FrontEndTrace>
              <ResponseCode>string</ResponseCode>
              <CustTransType>string</CustTransType>
              <BackEndSN>string</BackEndSN>
              <CustomerName>Rec1</CustomerName>
              <TransAmount>double</TransAmount>
              <EffectiveDate>dateTime</EffectiveDate>
              <ActionDate>dateTime</ActionDate>
              <ActionDetail>string</ActionDetail>
            </ACHReturnRecord>
            <ACHReturnRecord>
              <SSS>SS2</SSS>
              <LocID>LOC2</LocID>
              <SourceFile>Source2</SourceFile>
              <FrontEndTrace>string</FrontEndTrace>
              <ResponseCode>string</ResponseCode>
              <CustTransType>string</CustTransType>
              <BackEndSN>string</BackEndSN>
              <CustomerName>Rec2</CustomerName>
              <TransAmount>double</TransAmount>
              <EffectiveDate>dateTime</EffectiveDate>
              <ActionDate>dateTime</ActionDate>
              <ActionDetail>string</ActionDetail>
            </ACHReturnRecord>
           </ACHReturnRecords>
         </GetACHReturnsResult>
         </GetACHReturnsResponse>';


    public function __construct(RequestInterface $request, $data)
    {

        $this->request = $request;

        $this->ACHReturnRecords = array();

        if ($data->getStatusCode() != $this->VALID_RESPONSE) {
            throw new InvalidResponseException;
        }


        //
        //  This is for testing only
        $dom = new DOMDocument;
        $dom->loadXML($this->ACHHistReturnsResultTest);


        $responseDom = new DOMDocument;
        $responseDom->loadXML($data->getBody());
        $this->data = simplexml_import_dom($responseDom->documentElement->firstChild->firstChild);

        $this->achHistResult = simplexml_import_dom($dom);

        switch (strtolower($this->data->getName())) {
            case 'sendachtransresponse':
                $result = strtolower($this->data->SendACHTransResult->Status);
                if ($result != 'success') {
                    $this->StatusOK = false;
                    return;
                } else {
                    $this->StatusOK = true;
                    return;
                }
                break;
            case 'connectioncheckresponse':
                $result = strtolower($this->data->ConnectionCheckResult);
                if (strpos($result, 'success') !== false) {
                    $this->StatusOK = true;
                    return;
                } elseif (strpos($result, 'rejected')) {
                    $this->StatusOK = false;
                    return;
                } else {
                    throw new InvalidResponseException;
                }
                break;
            case 'checkcompanystatusresponse':
                $result = strtolower($this->data->CheckCompanyStatusResult);
                $this->ACHWorksResponseMessage = $result;
                if (strpos($result, 'success') !== false) {
                    $this->StatusOK = true;
                    return;
                } elseif (strpos($result, 'rejected') !== false) {
                    $this->StatusOK = false;
                    return;
                } else {
                    throw new InvalidResponseException;
                }
                break;
            case 'getachreturnshistresponse':
                $result = strtolower($this->data->GetACHReturnsHistResult->Status);
                //
                // TODO This is a dummy test, we will be rejected now. So we can verify dummy data returns
                foreach ($this->achHistResult->GetACHReturnsResult->ACHReturnRecords->ACHReturnRecord as $aRecord) {
                    /**
                     * @var \Omnipay\ACHWorks\ACHReturnRecord
                     */
                    $this->ACHReturnRecords[] = $this->loadHistory($aRecord);
                }
                $this->ACHWorksResponseMessage = (string)$this->data->GetACHReturnsResult->Details;
                if (strpos($result, 'rejected') !== false) {
                    $this->StatusOK = true;
                    //
                    // TODO Once we have an account verify this method works
                    foreach ($this->achHistResult->GetACHReturnsResult->ACHReturnRecords->ACHReturnRecord as $aRecord) {
                        /**
                         * @var \Omnipay\ACHWorks\ACHReturnRecord
                         */
                        $this->ACHReturnRecords[] = $this->loadHistory($aRecord);
                    }
                    return;
                } elseif (strpos($result, 'rejected') !== false) {
                    $this->StatusOK = false;
                    return;
                } else {
                    throw new InvalidResponseException;
                }
                break;
            case 'getachreturnsresponse':
                $result = strtolower($this->data->GetACHReturnsResult->Status);

                //
                // TODO This is a dummy test, we will be rejected now. So we can verify dummy data returns
                foreach ($this->achHistResult->GetACHReturnsResult->ACHReturnRecords->ACHReturnRecord as $aRecord) {
                    /**
                     * @var \Omnipay\ACHWorks\ACHReturnRecord
                     */
                    $this->ACHReturnRecords[] = $this->loadHistory($aRecord);
                }
                $this->ACHWorksResponseMessage = (string)$this->data->GetACHReturnsResult->Details;
                if (strpos($result, 'rejected') !== false) {
                    $this->StatusOK = true;
                    //
                    // TODO Once we have an account verify this method works
                    foreach ($this->achHistResult->GetACHReturnsResult->ACHReturnRecords->ACHReturnRecord as $aRecord) {
                        /**
                         * @var \Omnipay\ACHWorks\ACHReturnRecord
                         */
                        $this->ACHReturnRecords[] = $this->loadHistory($aRecord);
                    }
                    return;
                } elseif (strpos($result, 'rejected') !== false) {
                    $this->StatusOK = false;
                    return;
                } else {
                    throw new InvalidResponseException;
                }
                break;
            default:
                var_dump("Default", $this->data->getName());
                throw new InvalidResponseException;
        }
    }

    /*
     *  Given an ACHReturnRecord from the GetACHReturns or GetACHReturnsHist calls we create a local class item for
     *   addition to an array of Return Records
     */
    private function loadHistory($aRecord)
    {
        /**
         * @var \Omnipay\ACHWorks\ACHReturnRecord
         */
        $historyRecord = new ACHReturnRecord();
        $historyRecord->setSSS($aRecord->SSS);
        $historyRecord->setLocID($aRecord->LocID);
        $historyRecord->setSourceFile($aRecord->SourceFile);
        $historyRecord->setFrontEndTrace($aRecord->FrontEndTrace);
        $historyRecord->setResponseCode($aRecord->ResponseCode);
        $historyRecord->setCustTransType($aRecord->CustTransType);
        $historyRecord->setBackEndSN($aRecord->BackEndSN);
        $historyRecord->setCustomerName($aRecord->CustomerName);
        $historyRecord->setTransAmount($aRecord->TransAmount);
        $historyRecord->setEffectiveDate($aRecord->EffectiveDate);
        $historyRecord->setActionDate($aRecord->ActionDate);
        $historyRecord->setActionDetail($aRecord->ActionDetail);
        return $historyRecord;
    }

    public function getACHWorksResponseMessage()
    {
        return $this->ACHWorksResponseMessage;
    }

    public function getResultElement()
    {
        $resultElement = $this->data->getName();

        return $this->data->$resultElement;
    }

    public function isSuccessful()
    {
        return $this->StatusOK;
    }

    public function isRedirect()
    {
        return 3 === (int)$this->StatusOK;
    }

    public function getACHReturnRecords()
    {
        return $this->ACHReturnRecords;
    }


    public function getMessage()
    {
        return (string)$this->ACHWorksResponseMessage;
    }

    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return (string)$this->data->TransactionOutputData->ThreeDSecureOutputData->ACSURL;
        }
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $redirectData = array(
            'PaReq' => (string)$this->data->TransactionOutputData->ThreeDSecureOutputData->PaREQ,
            'TermUrl' => $this->getRequest()->getReturnUrl(),
            'MD' => (string)$this->data->TransactionOutputData['CrossReference'],
        );
    }
}
