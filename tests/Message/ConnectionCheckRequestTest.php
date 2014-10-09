<?php

namespace Omnipay\ACHWorks\Message;

use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;

class ConnectionCheckRequestTest extends ACHWorksTest
{

    public function setUp()
    {

        parent::setUp();

        $this->request = new ConnectionCheckRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'developerMode' => true,
                 'SSS' => 'TST',
                'LocID' => '9505',
                'CompanyKey' => 'SASD%!%$DGLJGWYRRDGDDUDFDESDHDD',
                'Company' => 'MYCOMPANY',
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->request->setTestMode(true);

        $this->request->send($data);

   //     $this->assertSame('TST', $data['SSS']);
    //    $this->assertSame('10.0.0.1', $data['x_customer_ip']);
    //    $this->assertSame('cust-id', $data['x_cust_id']);
    //    $this->assertArrayNotHasKey('x_test_request', $data);
    }
}
