<?php

namespace Omnipay\ACHWorks\Message;

use SimpleXMLElement;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * ACHWorks - Check Company Status Request -
 */
class CheckCompanyStatusRequest extends AbstractRequest
{
    public function getData()
    {


        $data = new SimpleXMLElement('<CheckCompanyStatus/>');
        $data->addAttribute('xmlns', $this->namespace);
        $data = $this->getInpCompanyData($data);
        var_dump("CheckCompanyStatus:", $data->asXML());
        return $data;
    }
}
