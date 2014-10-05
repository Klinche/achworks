<?php

namespace Omnipay\ACHWorks\Message;

use SimpleXMLElement;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * ACHWorks - Connection Check Request -
 */
class ConnectionCheckRequest extends AbstractRequest
{
    public function getData()
    {

        $data = new SimpleXMLElement('<ConnectionCheck/>');
        $data->addAttribute('xmlns', $this->namespace);
        $data = $this->getInpCompanyData($data);
        var_dump("ConnectionCheck:", $data->asXML());
        return $data;
    }
}
