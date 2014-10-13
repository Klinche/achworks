<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

/**
 * ACHWorks Purchase Request
 */
class PurchaseRequest extends AuthorizeRequest
{
    public $transactionType = 'PAYMENT';

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getData()
    {
        $this->getCustomerId();
        $data = $this->setupSendACHTrans('D'); // This is a generic transaction that can be done for either Debit or Credit!

        return $data;
    }


}
