<?php

namespace Omnipay\ACHWorks\Message;

use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;
use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function setUp()
    {

        $bankAccount = new BankAccount();
        $bankAccount->setAccountNumber("0512-351217");
        $bankAccount->setRoutingNumber("4271-04991");
        $bankAccount->setBankName("Mikey National Bank");
        $bankAccount->setBankAccountType(BankAccount::ACCOUNT_TYPE_CHECKING);

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'clientIp' => '10.0.0.1',
                'amount' => '12.00',
                'customerId' => 'cust-id',
                'card' => $this->getValidCard(),
                'bankAccount' => $bankAccount
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('AUTH_CAPTURE', $data['x_type']);
        $this->assertSame('10.0.0.1', $data['x_customer_ip']);
        $this->assertSame('cust-id', $data['x_cust_id']);
        $this->assertArrayNotHasKey('x_test_request', $data);
    }
}
