<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

use Omnipay\ACHWorks\BankAccount;

/**
 * Authorize.Net Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://secure.authorize.net/gateway/transact.dll';
    protected $developerEndpoint = 'https://test.authorize.net/gateway/transact.dll';
    protected $namespace  = "http://achworks.com/";
    protected $_companySSS = "TST";
    protected $_companyLocID = "9502";
    protected $_company = "MY COMPANY";
    protected $_companyKey = "";

    // ACHWorks saop ver4 guide.pdf says for testing use these credentials  (Sect 3.1.1 - 3.1.3)
    protected $_companySSS_TST = "TST";
    protected $_companyLocID_TST = "9502";
    protected $_company_TST = "MY COMPANY";


    public function setCompanySSS($value)
    {
        $this->_companySSS = $value;
    }

    public function getCompanySSS()
    {
        if ($this->getDeveloperMode())
           return ($this->_companySSS_TST);
        else
           return ($this->_companySSS);
    }
    public function setCompanyLocID($value)
    {
        $this->$_companyLocID = $value;
    }

    public function getCompanyLocID()
    {
        if ($this->getDeveloperMode())
            return ($this->_companyLocID_TST);
        else
            return ($this->_companyLocID);
    }

    public function setCompany($value)
    {
        $this->$_company = $value;
    }

    public function getCompany()
    {
        if ($this->getDeveloperMode())
            return ($this->_company_TST);
        else
            return ($this->_company);
    }

    public function setCompanyKey($value)
    {
        $this->$_companyKey = $value;
    }

    public function getCompanyKey()
    {
        return ($this->_companyKey);
    }

    public function getApiLoginId()
    {
        return $this->getParameter('apiLoginId');
    }

    public function setApiLoginId($value)
    {
        return $this->setParameter('apiLoginId', $value);
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

    public function getBankAccount()
    {
        return $this->getParameter('bankAccount');
    }

    public function setBankAccount($value)
    {
        if ($value && !$value instanceof BankAccount) {
            $value = new BankAccount($value);
        }

        return $this->setParameter('bankAccount', $value);
    }


    protected function getInpCompanyData(SimpleXMLElement $data)
    {
        $inpCompanyInfo = $data->addChild('InpCompanyInfo');
        $inpCompanyInfo->addChild('SSS',$this->getCompanySSS()) ;
        $inpCompanyInfo->addChild('LocID',$this->getCompanyLocID());
        $inpCompanyInfo->addChild('Company', $this->getCompany());
        $inpCompanyInfo->addChild('CompanyKey', $this->getCompanyKey());
        return $data;
    }

    protected function getBillingData()
    {
        $data = array();
        $data['x_amount'] = $this->getAmount();
        $data['x_invoice_num'] = $this->getTransactionId();
        $data['x_description'] = $this->getDescription();

        if ($card = $this->getCard()) {
            // customer billing details
            $data['x_first_name'] = $card->getBillingFirstName();
            $data['x_last_name'] = $card->getBillingLastName();
            $data['x_company'] = $card->getBillingCompany();
            $data['x_address'] = trim(
                $card->getBillingAddress1()." \n".
                $card->getBillingAddress2()
            );
            $data['x_city'] = $card->getBillingCity();
            $data['x_state'] = $card->getBillingState();
            $data['x_zip'] = $card->getBillingPostcode();
            $data['x_country'] = $card->getBillingCountry();
            $data['x_phone'] = $card->getBillingPhone();
            $data['x_email'] = $card->getEmail();

            // customer shipping details
            $data['x_ship_to_first_name'] = $card->getShippingFirstName();
            $data['x_ship_to_last_name'] = $card->getShippingLastName();
            $data['x_ship_to_company'] = $card->getShippingCompany();
            $data['x_ship_to_address'] = trim(
                $card->getShippingAddress1()." \n".
                $card->getShippingAddress2()
            );
            $data['x_ship_to_city'] = $card->getShippingCity();
            $data['x_ship_to_state'] = $card->getShippingState();
            $data['x_ship_to_zip'] = $card->getShippingPostcode();
            $data['x_ship_to_country'] = $card->getShippingCountry();
        } elseif ($bankAccount = $this->getBankAccount()) {
            // customer billing details
            $data['x_first_name'] = $bankAccount->getBillingFirstName();
            $data['x_last_name'] = $bankAccount->getBillingLastName();
            $data['x_company'] = $bankAccount->getBillingCompany();
            $data['x_address'] = trim(
                $bankAccount->getBillingAddress1()." \n".
                $bankAccount->getBillingAddress2()
            );
            $data['x_city'] = $bankAccount->getBillingCity();
            $data['x_state'] = $bankAccount->getBillingState();
            $data['x_zip'] = $bankAccount->getBillingPostcode();
            $data['x_country'] = $bankAccount->getBillingCountry();
            $data['x_phone'] = $bankAccount->getBillingPhone();
            $data['x_email'] = $bankAccount->getEmail();

            // customer shipping details
            $data['x_ship_to_first_name'] = $bankAccount->getShippingFirstName();
            $data['x_ship_to_last_name'] = $bankAccount->getShippingLastName();
            $data['x_ship_to_company'] = $bankAccount->getShippingCompany();
            $data['x_ship_to_address'] = trim(
                $bankAccount->getShippingAddress1()." \n".
                $bankAccount->getShippingAddress2()
            );
            $data['x_ship_to_city'] = $bankAccount->getShippingCity();
            $data['x_ship_to_state'] = $bankAccount->getShippingState();
            $data['x_ship_to_zip'] = $bankAccount->getShippingPostcode();
            $data['x_ship_to_country'] = $bankAccount->getShippingCountry();
        }

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
            'SOAPAction' => $this->namespace.$data->getName());

        var_dump("SendData Headers:", $headers);
        var_dump("SendData data:", $document);

        $httpResponse = $this->httpClient->post($this->endpoint, $headers, $document->saveXML())->send();

        return $this->response = new Response($this, $httpResponse->getBody());
    }
    public function getEndpoint()
    {
        return $this->getDeveloperMode() ? $this->developerEndpoint : $this->liveEndpoint;
    }
}
