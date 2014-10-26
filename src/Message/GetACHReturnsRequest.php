<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

/**
 * ACHWorks - Special function GetACHReturns request
 *
 *      NOTE: This request will only return the Returns since the last time this request was made. For date range use
 *      GetACHReturnsHistRequest
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

    }
}
