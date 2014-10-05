<?php

namespace Omnipay\ACHWorks\Message;

use Omnipay\Tests\TestCase;

class CheckCompanyStatusRequestTest extends TestCase
{
    protected $request;

    public function setUp()
    {
        $this->request = new CheckCompanyStatusRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            /*
            array(
                'clientIp' => '10.0.0.1',
                'amount' => '12.00',
                'customerId' => 'cust-id',
                'card' => $this->getValidCard(),
            )
            */
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        var_dump("TestGetData:", $data);

        $this->assertSame('AUTH_ONLY', $data['x_type']);
        $this->assertSame('10.0.0.1', $data['x_customer_ip']);
        $this->assertSame('cust-id', $data['x_cust_id']);
        $this->assertArrayNotHasKey('x_test_request', $data);
    }

    public function testGetDataTestMode()
    {
        $this->request->setTestMode(true);

        $data = $this->request->getData();

        $this->assertSame('TRUE', $data['x_test_request']);
    }

}
