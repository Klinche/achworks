<?php

namespace Omnipay\ACHWorks;


use Omnipay\ACHWorks\Message\ConnectionCheckRequest;
use Omnipay\ACHWorks\Message\CheckCompanyStatusRequest;
use Omnipay\Common\AbstractGateway;

/**
 * ACHWorksWS - Soap Gateway
 */
class ACHWorksWSGateway extends AbstractGateway
{

    /* Default Abstract Gateway methods that need to be overridden */
    public function getName()
    {
        return 'ACHWorksWS - Soap';
    }

    public function getDefaultParameters()
    {

        return array(
            'amount' => '0',
            // These are required to be set. If they are here as defaults tests fail
            //   'bankAccountPayee' => null,
            //  'bankAccountPayor' => null,
            'developerMode' => true,
            'memo' => 'ACHWorks',
            'SSS' => 'TST',
            'LocID' => '9505',
            'CompanyKey' => 'SASD%!%$DGLJGWYRRDGDDUDFDESDHDD',
            'Company' => 'MYCOMPANY',
            'TransactionType' => 'PPD',
            'OpCode' => 'S',
            'AccountSet' => '1',
        );
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setCheckNumber($value)
    {
        return $this->setParameter('CheckNumber', $value);
    }

    public function getCheckNumber()
    {
        return $this->getParameter('CheckNumber');
    }

    public function setBankAccountPayee($value)
    {
        return $this->setParameter('bankAccountPayee', $value);
    }

    public function getBankAccountPayee()
    {
        return $this->getParameter('amount');
    }

    public function setBankAccountPayor($value)
    {
        return $this->setParameter('bankAccountPayor', $value);
    }

    public function getBankAccountPayor()
    {
        return $this->getParameter('bankAccountPayor');
    }

    public function setDeveloperMode($value)
    {
        return $this->setParameter('developerMode', $value);
    }

    public function getDeveloperMode()
    {
        return $this->getParameter('developerMode');
    }

    public function setMemo($value)
    {
        return $this->setParameter('memo', $value);
    }

    public function getMemo()
    {
        return $this->getParameter('memo');
    }


    public function setSSS($value)
    {
        return $this->setParameter('SSS', $value);
    }

    public function getSSS()
    {
        return $this->getParameter('SSS');
    }

    public function setLocID($value)
    {
        return $this->setParameter('LocID', $value);
    }

    public function getLocID()
    {
        return $this->getParameter('LocID');
    }

    public function setCompanyKey($value)
    {
        return $this->setParameter('CompanyKey', $value);
    }

    public function getCompanyKey()
    {
        return $this->getParameter('CompanyKey');
    }

    public function setCompany($value)
    {
        return $this->setParameter('Company', $value);
    }

    public function getCompany()
    {
        return $this->getParameter('Company');
    }

    public function setTransactionType($value)
    {
        return $this->setParameter('TransactionType', $value);
    }

    public function getTransactionType()
    {
        return $this->getParameter('TransactionType');
    }

    public function setOpCode($value)
    {
        return $this->setParameter('OpCode', $value);
    }

    public function getOpCode()
    {
        return $this->getParameter('OpCode');
    }

    public function setAccountSet($value)
    {
        return $this->setParameter('AccountSet', $value);
    }

    public function getAccountSet()
    {
        return $this->getParameter('AccountSet');
    }

    /**
     * @param array $parameters
     * @return \Omnipay\ACHWorks\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\ACHWorks\Message\ReferencedPurchaseRequest
     */
    public function referencedPurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\ReferencedPurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\ACHWorks\Message\RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\RefundRequest', $parameters);
    }


    /* Extensions for ACHWorks */

    /*
     *  achworks-SoapVer4guide - Sect 2.1.1 -Connection Check
     *
     * @param array $parameters
     * @return \Omnipay\ACHWorks\Message\ConnectionCheckRequest
     */
    public function connectionCheck(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\ConnectionCheckRequest', $parameters);
    }

    /*
     *  achworks-SoapVer4guide - Sect 2.1.2 -Check Company Status
     *
     *
     * @param array $parameters
     * @return \Omnipay\ACHWorks\Message\CheckCompanyStatusRequest
     */
    public function checkCompanyStatus(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\CheckCompanyStatusRequest', $parameters);
    }

    /*
     *  achworks-SoapVer4guide - Sect 2.2.1 -SendACHTrans
     *
     * @param array $parameters
     * @return \Omnipay\ACHWorks\Message\SendACHTransRequest
     */
    public function sendACHTrans(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\SendACHTransRequest', $parameters);
    }

    /*
     *  achworks-SoapVer4guide - Sect 2.3.1 - GetACHReturns
     *
     * @param array $parameters
     * @return \Omnipay\ACHWorks\Message\GetACHReturnsRequest
     */
    public function getACHReturns(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\GetACHReturnsRequest', $parameters);
    }

    /*
     *  achworks-SoapVer4guide - Sect 2.4.1 - GetResultFile
     *
     * @param array $parameters
     * @return \Omnipay\ACHWorks\Message\GetResultFileRequest
     */
    public function getResultFile(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\GetResultFileRequest', $parameters);
    }

    /*
     *  achworks-SoapVer4guide - Sect 2.4.2 - GetErrorFile
      *
     * @param array $parameters
     * @return \Omnipay\ACHWorks\Message\GetErrorFileRequest
     */
    public function getErrorFile(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\GetErrorFileRequest', $parameters);
    }
}
