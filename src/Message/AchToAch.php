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
        // This is a generic transaction that can be done for either Debit or Credit!
        // The caller must set mode $this->setMode('D') or $this->setMode('C');
        $data = $this->setupSendACHTrans();

        return $data;
    }
}
