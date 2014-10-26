<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

/**
 * ACHWorks - Special function Retrieve ACHWorks history between 2 dates.
 *
 *      NOTE: This request will return Returns between the FromDate and ToDate.  Date format is YYYY-MM-DD leading
 *            zeros must be provided.  The get methods will attempt to format using the php Date request.
 */
class GetACHReturnsHistRequest extends AbstractRequest
{
    public $transactionType = 'GetACHHistReturns';

    public function getData()
    {
        $data = new SimpleXMLElement('<GetACHReturnsHist/>');
        $data->addAttribute('xmlns', $this->namespace);
        $data = $this->getInpCompanyData($data);
        // Format is date('Y-m-d') in php
        $data->addChild('ReturnDateFrom', $this->getParameter('FromDate'));
        $data->addChild('ReturnDateTo', $this->getParameter('ToDate'));
        return $data;
    }


    // Format is date('Y-m-d') in php
    public function setFromDate($value)
    {
        return $this->setParameter('FromDate', $value);
    }

    public function getFromDate()
    {
        // use \date so we work within symfony framework
        return \date('Y-m-d', $this->getParameter('FromDate'));
    }

    // Format is date('Y-m-d') in php
    public function setToDate($value)
    {
        return $this->setParameter('ToDate', $value);
    }

    public function getToDate()
    {
        // use \date so we work within symfony framework
        return \date('y-m-d', $this->getParameter('ToDate'));
    }
}
