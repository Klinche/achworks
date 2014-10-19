<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

/**
 * ACHWorks - Special function ACH to ACH transfer. From BankAccountA to BankAccountB
 */
class GetACHReturnsRequest extends AbstractRequest
{
    public $transactionType = 'GetACHReturns';

    public function getData()
    {
        $data = new SimpleXMLElement('<GetACHReturns/>');
        $data->addAttribute('xmlns', $this->namespace);
        $data = $this->getInpCompanyData($data);
        return $data;

        return $data;
    }
}
