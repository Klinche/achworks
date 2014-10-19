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
    private $ACHReturns = "";

    public function __construct(RequestInterface $request, $data)
    {

        $this->request = $request;

        if ($data->getStatusCode() != $this->VALID_RESPONSE) {
            throw new InvalidResponseException;
        }

        $responseDom = new DOMDocument;
        $responseDom->loadXML($data->getBody());
        $this->data = simplexml_import_dom($responseDom->documentElement->firstChild->firstChild);

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
                $this->ACHWorksResponseMessage = (string)$this->data->GetACHReturnsResult->Details;
                if (strpos($result, 'success') !== false) {
                    $this->StatusOK = true;
                    //
                    // TODO Once we have an account verify this method works
                    $this->ACHReturns = $this->data->GetACHRetrunsResult->ACHReturnsRecords;
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
