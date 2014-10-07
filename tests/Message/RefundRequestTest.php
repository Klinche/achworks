<?php

namespace Omnipay\ACHWorks\Message;

use Omnipay\Tests\TestCase;
use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;

class RefundRequestTest extends ACHWorksTest
{

    public function setUp()
    {
        parent::setUp();

        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'clientIp' => '10.0.0.1',
                'amount' => '12.00',
                'customerId' => 'cust-id',
                'card' => $this->getValidCard(),
                'bankAccount' => $this->bankAccount,
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->request->setTestMode(true);

        $resp= $this->request->sendData($data);

        var_dump("RefundRequestTest-sendData", $resp);
        $this->assertSame('AUTH_CAPTURE', $data['x_type']);
        $this->assertSame('10.0.0.1', $data['x_customer_ip']);
        $this->assertSame('cust-id', $data['x_cust_id']);
        $this->assertArrayNotHasKey('x_test_request', $data);
    }
}
