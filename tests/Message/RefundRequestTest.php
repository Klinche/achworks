<?php

namespace Omnipay\ACHWorks\Message;

use Omnipay\Tests\TestCase;
use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;
use DOMDocument;

class RefundRequestTest extends ACHWorksTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize(
            array(
                'amount' => '172.00',
                'bankAccountPayee' => $this->bankAccountPayee,
                'developerMode' => true,
                'memo' => 'RefundTest-ACHWorks',
                'SSS' => 'TST',
                'LocID' => '9505',
                'CompanyKey' => 'SASD%!%$DGLJGWYRRDGDDUDFDESDHDD',
                'Company' => 'MYCOMPANY',
                'TransactionType' => 'PPD',
                'OpCode' => 'S',
                'AccountSet' => '1',
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->request->setTestMode(true);
        /**
         * @var ResponseInterface
         */
        $response = $this->request->send($data);
        $this->assertEquals(true, $response->isSuccessful());
    }
}
