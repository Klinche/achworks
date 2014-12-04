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

    public function getData()
    {
        // This is a generic transaction that can be done for either Debit or Credit!
        $this->setMode('D');
        $data = $this->setupSendACHTrans('D');

        return $data;
    }
}
