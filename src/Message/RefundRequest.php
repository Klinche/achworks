<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

/**
 * ACHWorks Refund Request
 *
 *   Achworks uses the SendACHTransaction for both Debit and Credit, so we have an abstract method to fill it in.
 */
class RefundRequest extends AuthorizeRequest
{
    public $transactionType = 'REFUND';

    public function getData()
    {
        // This is a generic transaction that can be done for either Debit or Credit!
        $data = $this->setupSendACHTrans('C');

        return $data;
    }
}
