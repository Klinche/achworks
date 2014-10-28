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
 *    The Parameters in this class map to the ACHWorks Return record used in GetACHReturns and GetACHReturnsHist
 */
class ACHReturnRecord
{
    const ACH_RETURN_CODE_1SNT = "1SNT";
    const ACH_RETURN_CODE_2STL = "2STL";
    const ACH_RETURN_CODE_3RET = "3RET";
    const ACH_RETURN_CODE_4INT = "4INT";
    const ACH_RETURN_CODE_5COR = "5COR";
    const ACH_RETURN_CODE_9BNK = "9BNK";

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

    /**
     * SSS is a 3-letter code furnished to registered merchants. For sample codes and for using the test server, the value ‘TST’ is commonly used.
     *
     * @return mixed
     */
    public function getSSS()
    {
        return $this->getParameter('SSS');
    }

    public function setSSS($value)
    {
        return $this->setParameter("SSS", $value);
    }

    /**
     * LocID is a 4-digit alphanumeric code furnished to registered merchants. For sample codes and for using the test server, the value ‘9502’ or ‘9505’ is commonly used.
     *
     * @return mixed
     */
    public function getLocID()
    {
        return $this->getParameter('LocID');
    }

    public function setLocID($value)
    {
        return $this->setParameter("LocID", $value);
    }

    /**
     * This is the source file name of the returns. This is for internal use and can be used for tracking purposes.
     *
     * @return mixed
     */
    public function getSourceFile()
    {
        return $this->getParameter('SourceFile');
    }

    public function setSourceFile($value)
    {
        return $this->setParameter("SourceFile", $value);
    }

    /**
     * The FrontEndTrace is tracking ID of this particular record or transaction when it was sent or submitted to the ACH.
     *
     * @return mixed
     */
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

    /**
     * CustTransType is the transaction type. The value is either ‘D’ for debit customer account or ‘C’ for credit customer account. If the ResponseCode value is 9BNK, CustTransType is set to blank.
     *
     * @return string
     */
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

    /**
     * CustomerName is the name of the customer. The value, when transaction is first sent, is trimmed to the maximum length allowed by the ACH which 22 characters.
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->getParameter('CustomerName');
    }

    public function setCustomerName($value)
    {
        return $this->setParameter("CustomerName", $value);
    }

    /**
     * TransAmount is the amount of the transaction in US dollars, e.g. 575.45
     *
     * @return mixed
     */
    public function getTransAmount()
    {
        return $this->getParameter('TransAmount');
    }

    public function setTransAmount($value)
    {
        return $this->setParameter("TransAmount", $value);
    }

    /**
     * EffectiveDate is the date when the transaction was first submitted to the ACH system.
     *
     * @return mixed
     */
    public function getEffectiveDate()
    {
        return $this->getParameter('EffectiveDate');
    }

    public function setEffectiveDate($value)
    {
        return $this->setParameter("EffectiveDate", $value);
    }

    /**
     * ActionDate is the date which has a value depending on the ResponseCode (Section 3.4.5). It is very useful to the user in determining the order of events when reviewing or investigating a transaction.
     *   ResponseCode ActionDate
     *   1SNT:        Date transaction is sent to ACH
     *   2STL:        Date transaction was settled
     *   3RET:        Date transaction was returned bay ACH Receiver Bank 4INT: Date transaction was not processed and returned
     *   5COR:        Date correction was received from the ACH
     *   9BNK:        Date money was credited or debited to your bank
     *
     * @return mixed
     */
    public function getActionDate()
    {
        return $this->getParameter('ActionDate');
    }

    public function setActionDate($value)
    {
        return $this->setParameter("ActionDate", $value);
    }

    /**
     * ActionDetail contains a string of 32 characters and has a value depending on the ResponseCode (Section 3.4.5):
     *
     * ResponseCode ActionDetail
     *   1SNT: This field is blank
     *   2STL: Contains a settlement ID by which this transaction was settled, and a debit or credit was done into your bank account. The format for this is:
     *       “AAAAAAAA BBBBBB CC DD EEEEE” , where
     *       AAAAAAAA = 8 chars, is the settlement ID which also appears on your Bank statement. You can use this to reconcile with your bank Statement.
     *       BBBBBB = 6 chars, either “DEBIT” or “CREDIT” which refers to DEBIT/CREDIT to your bank account
     *       CC = 2 chars, your AccountSet (see Section 3.2.18) by which this transaction was settled. If this is blank, look for the value in EEEEE DD = 2 chars, either “TS” or “RS”. TS refers to settlement of this Transaction when it clears. RS is when a late return was received on a transaction which was previously settled.
     *       EEEEE = your AccountSet (see Section 3.2.18) by which this transaction was settled.
     *   3RET: Contains the Return Code from ACH. Some of the most common Return Codes are: R01 – Insufficient Funds
     *       R02 – Closed Account
     *       R03 – No Account
     *       R04 - Invalid Account Number R09 – Uncollected Funds
     *       Please contact ACHWorks for a complete list of Return Codes.
     *   4INT: Contains the Internal Return Code from ACHWorks. common Internal Return Codes are:
     *       X01 – Insufficient Funds
     *       X02 – Closed Account
     *       X03 – No Account
     *       X04 - Invalid Account Number
     *       Some of the most Please contact ACHWorks for a complete list of Internal Return Codes.
     *   5COR: Contains the correction code and values from the ACH. Of the 32 characters of the ActionDetail, the first 3 characters is the Correction Code. The remaining 29 characters contains the correction value. If the Correction Code is:
     *       C03 (Incorrect Routing and Acct No), the correction routing number is contained from the 4th to the 12th character. The correction account number is contained from the 16th to 32nd (the last character).
     *       C06, the correction account number is contained from the 4th to the 20th character. The correction transaction code is contained from 24th to 25th character.
     *       C07, the correction routing number is contained from the 4th to the 12th character. The correction account number is contained from the 13th to the 29th character. The correction transaction code is contained from 30th to 31st character.
     *   9BNK: Refer to a settlement ID that would also appear on your bank statement. This corresponds to a collection of your transactions (2STL) with the same settlement IDs. Use this to reconcile with your bank statement.
     *
     * @return mixed
     */
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
