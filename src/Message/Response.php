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

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;

        if ($data->getStatusCode() != 200)
            throw new InvalidResponseException;

        $responseDom = new DOMDocument;
        $responseDom->loadXML($data->getBody());
  //      var_dump("ResponseDOM", $responseDom);
        $this->data = simplexml_import_dom($responseDom->documentElement->firstChild->firstChild);
     //   var_dump("RESPONSE DATA", $this->data);

        switch (strtolower($this->data->getName()))
        {
            case 'sendachtransresponse':
                $result =  strtolower($this->data->SendACHTransResult->Status);
                if ($result != 'success')
                {
                    var_dump("Status Dump:", $this->data);
                    throw new InvalidResponseException;
                }
                else
                {
                    $StatusOK = true;
                    return;
                }
                break;
            case 'connectioncheckresponse':
                $result = strtolower($this->data->ConnectionCheckResult);
                 if (strpos($result,'success') !== FALSE)
                 {
                     $StatusOK = true;
                     return;
                 }
                    else
                      throw new InvalidResponseException;
                break;
            default:
                var_dump("Default", $this->data->getName());
                throw new InvalidResponseException;
        }
    }

    public function getResultElement()
    {
        $resultElement = preg_replace('/Response$/', 'Result', $this->data->getName());

        return $this->data->$resultElement;
    }

    public function isSuccessful()
    {
        return 0 === (int) $this->StatusOK;
    }

    public function isRedirect()
    {
        return 3 === (int) $this->StatusOK;
    }


    public function getTransactionReference()
    {
        return (string) $this->data->TransactionOutputData['CrossReference'];
    }

    public function getMessage()
    {
        return (string) $this->getResultElement()->Message;
    }

    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return (string) $this->data->TransactionOutputData->ThreeDSecureOutputData->ACSURL;
        }
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $redirectData = array(
            'PaReq' => (string) $this->data->TransactionOutputData->ThreeDSecureOutputData->PaREQ,
            'TermUrl' => $this->getRequest()->getReturnUrl(),
            'MD' => (string) $this->data->TransactionOutputData['CrossReference'],
        );
    }
}
