<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

/**
 * ACHWorks - Special function ACH to ACH transfer. From BankAccountA to BankAccountB
 */
class AchToAchRequest extends AuthorizeRequest
{
    public $transactionType = 'ACH2ACH';

    public function getData()
    {
         // This is a generic transaction that can be done for either Debit or Credit!
        // The caller must set mode $this->setMode('D') or $this->setMode('C');
        $data = $this->setupSendACHTrans();

        return $data;
    }
}
