<?php

namespace Omnipay\ACHWorks;

use Omnipay\Tests\GatewayTestCase;

class ACHWorksGateWayTest extends GatewayTestCase
{
    protected $voidOptions;

    public $gateway = null;

    public function setUp()
    {
        parent::setUp();


        $bankAccount = new BankAccount();
        $bankAccount->setAccountNumber("0512-351217");
        $bankAccount->setRoutingNumber("4271-04991");
        $bankAccount->setBankName("Mikey National Bank");
        $bankAccount->setBankAccountType(BankAccount::ACCOUNT_TYPE_CHECKING);

        $this->gateway = new ACHWorksWSGateway($this->getHttpClient(), $this->getHttpRequest());

        $this->gateway->setTestMode(true);
        $this->gateway->connectionCheck();

        $this->purchaseOptions = array(
            'amount' => '10.00',
            'bankAccountPayee' => $this->bankAccount,

        );
        //    $response = $this->gateway->purchase($this->purchaseOptions);
        //    var_dump("ACHWorksGatewayTest", $response);

        $this->captureOptions = array(
            'amount' => '10.00',
            'transactionReference' => '12345',
        );

        $this->voidOptions = array(
            'transactionReference' => '12345',
        );
    }
}
