<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10/4/14
 * Time: 10:58 am
 */

namespace Omnipay\ACHWorks;

use DateTime;
use DateTimeZone;
use Symfony\Component\HttpFoundation\ParameterBag;
use Omnipay\Common\Helper;

/**
 * ACHWorks return class- Contains data from a Returns Request
 *    The Parameters in this class map to the ACHWorks Return record
 */
class ACHReturnRecord
{

    /**
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $parameters;

    /**
     * Create a new CreditCard object using the specified parameters
     *
     * @param array $parameters An array of parameters to set on the new object
     */
    public function __construct($parameters = null)
    {
        $this->initialize($parameters);
    }

    /**
     * Initialize the object with parameters.
     *
     * If any unknown parameters passed, they will be ignored.
     *
     * @param array $parameters An associative array of parameters
     *
     * @return $this
     */
    public function initialize($parameters = null)
    {
        $this->parameters = new ParameterBag;

        Helper::initialize($this, $parameters);

        return $this;
    }

    public function getSSS()
    {
        return $this->getParameter('SSS');
    }

    public function setSSS($value)
    {
        return $this->setParameter("SSS", $value);
    }

    public function getLocID()
    {
        return $this->getParameter('LocID');
    }

    public function setLocID($value)
    {
        return $this->setParameter("LocID", $value);
    }

    public function getSourceFile()
    {
        return $this->getParameter('SourceFile');
    }

    public function setSourceFile($value)
    {
        return $this->setParameter("SourceFile", $value);
    }

    public function getFrontEndTrace()
    {
        return $this->getParameter('FrontEndTrace');
    }

    public function setFrontEndTrace($value)
    {
        return $this->setParameter("FrontEndTrace", $value);
    }

    public function getResponseCode()
    {
        return $this->getParameter('ResponseCode');
    }

    public function setResponseCode($value)
    {
        return $this->setParameter("ResponseCode", $value);
    }

    public function getCustTransType()
    {
        return $this->getParameter('CustTransType');
    }

    public function setCustTransType($value)
    {
        return $this->setParameter("CustTransType", $value);
    }

    public function getBackEndSN()
    {
        return $this->getParameter('BackEndSN');
    }

    public function setBackEndSN($value)
    {
        return $this->setParameter("BackEndSN", $value);
    }

    public function getCustomerName()
    {
        return $this->getParameter('CustomerName');
    }

    public function setCustomerName($value)
    {
        return $this->setParameter("CustomerName", $value);
    }

    public function getTransAmount()
    {
        return $this->getParameter('TransAmount');
    }

    public function setTransAmount($value)
    {
        return $this->setParameter("TransAmount", $value);
    }

    public function getEffectiveDate()
    {
        return $this->getParameter('EffectiveDate');
    }

    public function setEffectiveDate($value)
    {
        return $this->setParameter("EffectiveDate", $value);
    }

    public function getActionDate()
    {
        return $this->getParameter('ActionDate');
    }

    public function setActionDate($value)
    {
        return $this->setParameter("ActionDate", $value);
    }

    public function getActionDetail()
    {
        return $this->getParameter('ActionDetail');
    }

    public function setActionDetail($value)
    {
        return $this->setParameter("ActionDetail", $value);
    }

    public function getParameters()
    {
        return $this->parameters->all();
    }

    protected function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    protected function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);

        return $this;
    }
}
