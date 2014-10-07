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
        $this->bankAccount->setCompany("DAB2LLC");

    }
}
