<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
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
    private $ACHReturnRecords = "";
    private $ACHHistReturnsResultTest = '<?xml version="1.0" encoding="utf-8"?>
<GetACHReturnsResponse xmlns="http://achworks.com/">
<GetACHReturnsResult>
<SSS>string</SSS>
<LocID>string</LocID>
<Status>string</Status>
<Details>string</Details>
<TotalNumRecords>int</TotalNumRecords>
<ReturnDateFrom>dateTime</ReturnDateFrom>
<ReturnDateTo>dateTime</ReturnDateTo>
<TotalNumErrors>int</TotalNumErrors>
<Errors>
<string>string</string>
<string>string</string>
</Errors>
<ACHReturnRecords>
<ACHReturnRecord>
<SSS>string</SSS>
<LocID>string</LocID>
<SourceFile>string</SourceFile>
<FrontEndTrace>string</FrontEndTrace>
<ResponseCode>string</ResponseCode>
<CustTransType>string</CustTransType>
<BackEndSN>string</BackEndSN>
<CustomerName>string</CustomerName>
<TransAmount>double</TransAmount>
<EffectiveDate>dateTime</EffectiveDate>
<ActionDate>dateTime</ActionDate>
<ActionDetail>string</ActionDetail>
</ACHReturnRecord>
<ACHReturnRecord>
<SSS>string</SSS>
<LocID>string</LocID>
<SourceFile>string</SourceFile>
<FrontEndTrace>string</FrontEndTrace>
<ResponseCode>string</ResponseCode>
<CustTransType>string</CustTransType>
<BackEndSN>string</BackEndSN>
<CustomerName>string</CustomerName>
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

        if ($data->getStatusCode() != $this->VALID_RESPONSE) {
            throw new InvalidResponseException;
        }



        $dom=new domDocument;
        $dom->loadXML($this->ACHHistReturnsResultTest);


        $responseDom = new DOMDocument;
        $responseDom->loadXML($data->getBody());
        $this->data = simplexml_import_dom($responseDom->documentElement->firstChild->firstChild);

        $this->achHistResult = simplexml_import_dom($dom);;

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
            case 'getachreturnsresponse':
                $result = strtolower($this->data->GetACHReturnsResult->Status);
                var_dump("HISTORY RESP TEST:",  $this->achHistResult);
                var_dump("Record:", $this->achHistResult->ACHReturnsRecords);
                $this->ACHWorksResponseMessage = (string)$this->data->GetACHReturnsResult->Details;
                if (strpos($result, 'rejected') !== false) {
                    $this->StatusOK = true;
                    //
                    // TODO Once we have an account verify this method works
                    $this->ACHReturnRecords = $this->data->GetACHReturnsResult->ACHReturnsRecords;
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

    public function getACHReturns()
    {
        return $this->ACHReturns;
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
