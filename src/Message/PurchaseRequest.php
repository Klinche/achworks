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

         $data = $this->setupSendACHTrans("D"); // This is a generic transaction that can be done for either Debit or Credit!

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


}
