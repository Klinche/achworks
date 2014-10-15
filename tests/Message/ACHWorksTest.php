<?php

namespace Omnipay\ACHWorks\Message;


use Omnipay\Tests\TestCase;
use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;

class ACHWorksTest extends TestCase
{
    public $request = null;
    public $bankAccountPayee = null;
    public $bankAccountPayor = null;

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

        $this->bankAccountPayor = new BankAccount();
        $this->bankAccountPayor->setAccountNumber("0512-351123");
        $this->bankAccountPayor->setRoutingNumber("4271-04881");
        $this->bankAccountPayor->setBankName("Freddy National Bank");
        $this->bankAccountPayor->setBankAccountType(BankAccount::ACCOUNT_TYPE_CHECKING);
        $this->bankAccountPayor->setBillingFirstName("Freddy");
        $this->bankAccountPayor->setBillingLastName("DABLname");
        $this->bankAccountPayor->setName("Freddy DABLname");
        $this->bankAccountPayor->setBillingAddress1("15502 K Street");
        $this->bankAccountPayor->setBillingCity("Washington DC");
        $this->bankAccountPayor->setBillingName("FED-Payee");
        $this->bankAccountPayor->setBillingPostcode("20003");
        $this->bankAccountPayor->setBillingState("DC, NE");
        $this->bankAccountPayor->setCompany("DAB2LLC2");

    }

    public function testSetUp()
    {
        $data = $this->setUp();

    }
}
