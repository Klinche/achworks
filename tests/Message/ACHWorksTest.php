<?php

namespace Omnipay\ACHWorks\Message;


use Omnipay\Tests\TestCase;
use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;

class ACHWorksTest extends TestCase
{
    public $request = null;
    public $bankAccountPayee = null;

    public function setUp()
    {
        $this->bankAccountPayee = new BankAccount();
        $this->bankAccountPayee->setAccountNumber("0512-351217");
        $this->bankAccountPayee->setRoutingNumber("4271-04991");
        $this->bankAccountPayee->setBankName("Mikey National Bank");
        $this->bankAccountPayee->setBankAccountType(BankAccount::ACCOUNT_TYPE_CHECKING);
        $this->bankAccountPayee->setBillingFirstName("Mikey");
        $this->bankAccountPayee->setBillingLastName("DABLname");
        $this->bankAccountPayee->setName("Mikey DABLname");
        $this->bankAccountPayee->setBillingAddress1("15505 Pennsylvania Ave.");
        $this->bankAccountPayee->setBillingCity("Washington DC");
        $this->bankAccountPayee->setBillingName("FED-Payor");
        $this->bankAccountPayee->setBillingPostcode("20003");
        $this->bankAccountPayee->setBillingState("DC, NE");
        $this->bankAccountPayee->setCompany("DAB2LLC");

    }
    public function testSetUp()
    {
        $data = $this->setUp();

    }
}
