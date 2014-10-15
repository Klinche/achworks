<?php

namespace Omnipay\ACHWorks;

use Omnipay\Tests\GatewayTestCase;

class ACHWorksGateWayTest extends GatewayTestCase
{
    protected $voidOptions;

    public $bankAccountPayee = null;
    public $bankAccountPayor = null;
    public $gateway = null;
    public $purchaseOptions = null;

    public function setUp()
    {
        parent::setUp();

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

        $this->gateway = new ACHWorksWSGateway($this->getHttpClient(), $this->getHttpRequest());

        $this->gateway->setTestMode(true);
        $this->gateway->connectionCheck();

        $this->purchaseOptions = array(
            'amount' => '12.00',
            'bankAccountPayor' => $this->bankAccountPayee,
            'bankAccountPayee' => $this->bankAccountPayee,
            'CheckNumber' => '123',
            'developerMode' => true,
            'memo' => 'PurchaseTest-ACHWorks',
            'SSS' => 'TST',
            'LocID' => '9505',
            'CompanyKey' => 'SASD%!%$DGLJGWYRRDGDDUDFDESDHDD',
            'Company' => 'MYCOMPANY',
            'TransactionType' => 'PPD',
            'OpCode' => 'S',
            'AccountSet' => '1',
        );

        /** @var \Omnipay\ACHWorks\Message\PurchaseRequest $request */
        $request = $this->gateway->purchase($this->purchaseOptions);

        /** @var \Omnipay\ACHWorks\Message\Response $response */
        $response = $request->send();
        $this->assertEquals(true, $response->isSuccessful());
    }
}
