<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;

/**
 * Authorize.Net Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'http://tstsvr.achworks.com/dnet/achws.asmx'; // TODO NEED TO CHANGE WHEN PROVIDED
    protected $developerEndpoint = 'http://tstsvr.achworks.com/dnet/achws.asmx';
    protected $namespace = "http://achworks.com/";

    public function getMemo()
    {
        return $this->getParameter('memo');
    }


    public function setMemo($value)
    {
        return $this->setParameter('memo', $value);
    }


    public function getCheckNumber()
    {
        return $this->getParameter('checkNumber');
    }

    public function setCheckNumber($value)
    {
        return $this->setParameter('checkNumber', $value);
    }


    public function getTransactionKey()
    {
        return $this->getParameter('transactionKey');
    }

    public function setTransactionKey($value)
    {
        return $this->setParameter('transactionKey', $value);
    }

    public function getDeveloperMode()
    {
        return $this->getParameter('developerMode');
    }

    public function setDeveloperMode($value)
    {
        return $this->setParameter('developerMode', $value);
    }

    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }

    public function getHashSecret()
    {
        return $this->getParameter('hashSecret');
    }

    public function setHashSecret($value)
    {
        return $this->setParameter('hashSecret', $value);
    }

    public function getBankAccountPayee()
    {
        return $this->getParameter('bankAccountPayee');
    }

    public function setBankAccountPayee($value)
    {
        if ($value && !$value instanceof BankAccount) {
            $value = new BankAccount($value);
        }

        return $this->setParameter('bankAccountPayee', $value);
    }

    //
    // achWorks Soap Ver 4 Guide- Sect 3.1.1 You need to have these all set to our customer info provided by ACHWorks
    public function getLocID()
    {
        return $this->getParameter('LocID');
    }

    public function setLocID($value)
    {
        return $this->setParameter('LocID', $value);
    }

    public function getSSS()
    {
        return $this->getParameter('SSS');
    }

    public function setSSS($value)
    {
        return $this->setParameter('SSS', $value);
    }

    public function getCompany()
    {
        return $this->getParameter('Company');
    }

    public function setCompany($value)
    {
        return $this->setParameter('Company', $value);
    }

    public function getCompanyKey()
    {
        return $this->getParameter('CompanyKey');
    }

    public function setCompanyKey($value)
    {
        return $this->setParameter('CompanyKey', $value);
    }

    public function getTransactionType()
    {
        return $this->getParameter('TransactionType');
    }

    public function setTransactionType($value)
    {
        return $this->setParameter('TransactionType', $value);
    }

    public function getOpCode()
    {
        return $this->getParameter('OpCode');
    }

    public function setOpCode($value)
    {
        return $this->setParameter('OpCode', $value);
    }

    // Merchant's may have multiple account sets. IE; Account set 1 = BofA, Account set 2 = WellsFarge
    public function getAccountSet()
    {
        return $this->getParameter('AccountSet');
    }

    public function setAccountSet($value)
    {
        return $this->setParameter('AccountSet', $value);
    }

    protected function getInpCompanyData(SimpleXMLElement $data)
    {
        $inpCompanyInfo = $data->addChild('InpCompanyInfo');
        $this->getHashSecret();
        $inpCompanyInfo->addChild('SSS', $this->getParameter('SSS'));
        $inpCompanyInfo->addChild('LocID', $this->getParameter('LocID'));
        $inpCompanyInfo->addChild('Company', $this->getParameter('Company'));
        $inpCompanyInfo->addChild('CompanyKey', $this->getParameter('CompanyKey'));
        return $data;
    }

    /**
     * setupSendACHTrans - Initialize a basic sendACHTransaction. It can be either Debit or Credit
     *
     * @param $custTransType  a String either 'D' or 'C' for the transaction
     *
     * @return $data- A SimpleXMLElement with all the nodes filled in
     */
    public function setupSendACHTrans($custTransType)
    {

        $data = new SimpleXMLElement('<SendACHTrans/>');
        $data->addAttribute('xmlns', $this->namespace);
        $data = $this->getInpCompanyData($data);
        $dataInpACHTransRecord = $data->addChild('InpACHTransRecord');

        $dataInpACHTransRecord->addChild('SSS', $this->getParameter('SSS'));
        $dataInpACHTransRecord->addChild('LocID', $this->getParameter('LocID'));


        // Unique ID that does not start with W. And can't be more than 12 characters
        $feTrace = substr('K' . uniqid(), 0, 10);
        $dataInpACHTransRecord->addChild('FrontEndTrace', $feTrace);
        $dataInpACHTransRecord->addChild('OriginatorName', $this->getParameter("Company"));

        //TODO - We need to determine whether this is PPD or CCD?
        $dataInpACHTransRecord->addChild('TransactionCode', $this->getParameter('TransactionType')); // PPD or CCD?

        // DEBIT or CREDIT - Use 'D' or 'C' Don't know if ACH works can handle lower caase, so just make sure it's UPPER
        $dataInpACHTransRecord->addChild('CustTransType', strtoupper($custTransType));

        $dataInpACHTransRecord->addChild('CustomerID', $this->getBankAccountPayee()->getName());

        $fname = $this->getBankAccountPayee()->getFirstName();
        $lname = $this->getBankAccountPayee()->getLastName();

        $custLFname = strtoupper($fname . "," . $lname);
        $dataInpACHTransRecord->addChild('CustomerName', $custLFname);
        $dataInpACHTransRecord->addChild('CustomerRoutingNo', $this->getBankAccountPayee()->getRoutingNumber());
        $dataInpACHTransRecord->addChild('CustomerAcctNo', $this->getBankAccountPayee()->getAccountNumber());

        // Checking 'C' or Savings  'S'
        if ($this->getBankAccountPayee()->getBankAccountType() == BankAccount::ACCOUNT_TYPE_CHECKING) {
            $dataInpACHTransRecord->addChild('CustomerAcctType', "C");
        } elseif ($this->getBankAccountPayee()->getBankAccountType() == BankAccount::ACCOUNT_TYPE_SAVINGS) {
            $dataInpACHTransRecord->addChild('CustomerAcctType', "S");
        } elseif ($this->getBankAccountPayee()->getBankAccountType() == BankAccount::ACCOUNT_TYPE_BUSINESS_CHECKING) {
            $dataInpACHTransRecord->addChild('CustomerAcctType', "C");
        }

        $dataInpACHTransRecord->addChild('TransAmount', $this->getAmount());
        $dataInpACHTransRecord->addChild('CheckOrCustID', $this->getCheckNumber());

        date_default_timezone_set('UTC');
        $dataInpACHTransRecord->addChild('CheckOrTransDate', date('Y-m-d'));
        // The $$ amount will not be sent to ACH until this date
        $dataInpACHTransRecord->addChild('EffectiveDate', date('Y-m-d'));
        $memoStr = substr($this->getMemo(), 0, 10); // Memo can't be longer then 10 characters
        $dataInpACHTransRecord->addChild('Memo', $memoStr);

        //  'S' for Single Entry or 'R' for recurring.
        $dataInpACHTransRecord->addChild('OpCode', $this->getParameter('OpCode'));

        // Merchant's may have multiple account sets. IE; Account set 1 = BofA, Account set 2 = WellsFarge
        $dataInpACHTransRecord->addChild('AccountSet', $this->getParameter('AccountSet'));

        var_dump("ACH DATA", $data);
        return $data;
    }


    public function sendData($data)
    {
        // Copied from CardSave
        // - the PHP SOAP library sucks, and SimpleXML can't append element trees
        // TODO: find PSR-0 SOAP library
        $document = new DOMDocument('1.0', 'utf-8');
        $envelope = $document->appendChild(
            $document->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'soap:Envelope')
        );
        $envelope->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $envelope->setAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        $body = $envelope->appendChild($document->createElement('soap:Body'));
        $body->appendChild($document->importNode(dom_import_simplexml($data), true));

        // post to ACHWorks
        $headers = array(
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => $this->namespace . $data->getName());

        var_dump("SendData data:", $document->saveXML());

        $httpResponse = $this->httpClient->post($this->getEndpoint(), $headers, $document->saveXML())->send();

        $theResponse = strtolower($httpResponse->getMessage());
        var_dump("sendData:", $theResponse);
        return $this->response = new Response($this, $httpResponse);
    }

    public function getEndpoint()
    {
        return $this->getDeveloperMode() ? $this->developerEndpoint : $this->liveEndpoint;
    }
}
