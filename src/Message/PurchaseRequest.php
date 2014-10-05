<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

/**
 * ACHWorks Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    protected $endpoint = 'https://achworks.com/';
    protected $namespace = 'http://achworks.com/';

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getData()
    {
        /*
         * Klinche already has the money in the account, so we probably don't need to validate the card, but in case...

           $this->validate('amount', 'card');
           $this->getCard()->validate();
        */


        $data = new SimpleXMLElement('<SendACHTrans/>');
        $data->addAttribute('xmlns', $this->namespace);
        $data = $this->getInpCompanyData($data);
        $dataInpACHTransRecord = $data->addChild('InpACHTransRecord');

        $dataInpACHTransRecord->addChild('SSS',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('LocID',$this->getCompanySSS()) ;


        $dataInpACHTransRecord->addChild('FrontEndTrace',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('OriginatorName',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('TransactionCode',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('CustTransType',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('CustomerID',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('CustomerName',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('CustomerRoutingNo',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('CustomerAcctNo',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('CustomerAcctType',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('TransAmount',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('CheckOrCustID',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('CheckOrTransDate',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('EffectiveDate',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('Memo',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('OpCode',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('EffectiveDate',$this->getCompanySSS()) ;
        $dataInpACHTransRecord->addChild('AccountSet',$this->getCompanySSS()) ;


        /*
        ** For testing only
        */
            $document = new DOMDocument('1.0', 'utf-8');
            $envelope = $document->appendChild(
                $document->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'soap:Envelope')
            );
            $envelope->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
            $envelope->setAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
            $body = $envelope->appendChild($document->createElement('soap:Body'));
            $body->appendChild($document->importNode(dom_import_simplexml($data), true));
            var_dump("PurchaseReq-XML:", $document->saveXML());
       /* end of testing */

        return $data;
    }

    public function sendData($data)
    {
        // the PHP SOAP library sucks, and SimpleXML can't append element trees - Uses SOAP 1.1 envelope here
        // TODO: find PSR-0 SOAP library
        $document = new DOMDocument('1.0', 'utf-8');
        $envelope = $document->appendChild(
            $document->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'soap:Envelope')
        );
        $envelope->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $envelope->setAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        $body = $envelope->appendChild($document->createElement('soap:Body'));
        $body->appendChild($document->importNode(dom_import_simplexml($data), true));

        // post to Cardsave
        $headers = array(
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => $this->namespace.$data->getName());

        $httpResponse = $this->httpClient->post($this->endpoint, $headers, $document->saveXML())->send();

        return $this->response = new Response($this, $httpResponse->getBody());
    }
}
