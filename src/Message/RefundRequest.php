<?php

namespace Omnipay\ACHWorks\Message;

use DOMDocument;
use SimpleXMLElement;

/**
 * ACHWorks Refund Request
 *
 *   Achworks uses the SendACHTransaction for both Debit and Credit, so we have an abstract method to fill it in.
 */
class RefundRequest extends AbstractRequest
{
    public $transactionType = 'REFUND';

    public function getData()
    {

        $data = $this->setupSendACHTrans("C"); // This is a generic transaction that can be done for either Debit or Credit!

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
        var_dump("RefundRequest-XML:", $document->saveXML());
        /* end of testing */

        return $data;
    }
}
