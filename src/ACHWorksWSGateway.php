<?php

namespace Omnipay\ACHWorks;


use Omnipay\ACHWorks\Message\ConnectionCheckRequest;
use Omnipay\ACHWorks\Message\CheckCompanyStatusRequest;
use Omnipay\ACHWorks\Message\SendACHTransRequest;
use Omnipay\ACHWorks\Message\GetACHReturnsRequest;
use Omnipay\ACHWorks\Message\GetResultFileRequest;
use Omnipay\ACHWorks\Message\GetErrorFileRequest;
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
        $parameters = parent::getDefaultParameters();
        $parameters['hashSecret'] = '';

        return $parameters;
    }

    public function getHashSecret()
    {
        return $this->getParameter('hashSecret');
    }

    public function setHashSecret($value)
    {
        return $this->setParameter('hashSecret', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\ConnectionCheckRequest', $parameters);
     //   return $this->getHashSecret();
    }

    /* Extensions for ACHWorks */

    /*
     *  achworks-SoapVer4guide - Sect 2.1.1 -Connection Check
     */
    public function connectionCheck(array $parameters = array())
    {
         return $this->createRequest('\Omnipay\ACHWorks\Message\ConnectionCheckRequest', $parameters);
    }

    /*
     *  achworks-SoapVer4guide - Sect 2.1.2 -Check Company Status
     */
    public function checkCompanyStatus(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\CheckCompanyStatusRequest', $parameters);
    }

    /*
     *  achworks-SoapVer4guide - Sect 2.2.1 -SendACHTrans
     */
    public function sendACHTrans(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\SendACHTransRequest', $parameters);
    }

    /*
     *  achworks-SoapVer4guide - Sect 2.3.1 - GetACHReturns
     */
    public function getACHReturns(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\GetACHReturnsRequest', $parameters);
    }

    /*
     *  achworks-SoapVer4guide - Sect 2.4.1 - GetResultFile
     */
    public function getResultFile(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\GetResultFileRequest', $parameters);
    }

    /*
     *  achworks-SoapVer4guide - Sect 2.4.2 - GetErrorFile
     */
    public function getErrorFile(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ACHWorks\Message\GetErrorFileRequest', $parameters);
    }

}
