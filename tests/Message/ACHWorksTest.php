<?php

namespace Omnipay\ACHWorks\Message;


use Omnipay\Tests\TestCase;
use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;

class ACHWorksTest extends TestCase
{
    public $request = null;
    public $bankAccount = null;

    public function setUp()
    {
        $this->bankAccount = new BankAccount();
        $this->bankAccount->setAccountNumber("0512-351217");
        $this->bankAccount->setRoutingNumber("4271-04991");
        $this->bankAccount->setBankName("Mikey National Bank");
        $this->bankAccount->setBankAccountType(BankAccount::ACCOUNT_TYPE_CHECKING);
        $this->bankAccount->setBillingFirstName("Mikey");
        $this->bankAccount->setBillingLastName("DABLname");
        $this->bankAccount->setName("Mikey DABLname");
        $this->bankAccount->setBillingAddress1("15505 Pennsylvania Ave.");
        $this->bankAccount->setBillingCity("Washington DC");
        $this->bankAccount->setBillingName("FED-Payor");
        $this->bankAccount->setBillingPostcode("20003");
        $this->bankAccount->setBillingState("DC, NE");
        $this->bankAccount->setCompany("DAB2LLC");

    }
    public function testSetUp()
    {
        $data = $this->setUp();

    }
}
