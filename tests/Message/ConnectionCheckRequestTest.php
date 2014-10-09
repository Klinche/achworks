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
                'clientIp' => '10.0.0.1',
                'amount' => '12.00',
                'customerId' => 'cust-id',
                'card' => $this->getValidCard(),
                'bankAccount' => $this->bankAccount

            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();

   //     $this->assertSame('TST', $data['SSS']);
    //    $this->assertSame('10.0.0.1', $data['x_customer_ip']);
    //    $this->assertSame('cust-id', $data['x_cust_id']);
    //    $this->assertArrayNotHasKey('x_test_request', $data);
    }
}
