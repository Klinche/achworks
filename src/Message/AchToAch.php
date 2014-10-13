<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

/**
 * ACHWorks - Special function ACH to ACH transfer. From BankAccountA to BankAccountB
 */
class AchToAch extends PurchaseRequest
{
    public $transactionType = 'ACH2ACH';

    public function getData()
    {
        $this->getCustomerId();
        $data = $this->setupSendACHTrans('D'); // This is a generic transaction that can be done for either Debit or Credit!

        return $data;
    }


}
