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


        $bankAccountPayee = new BankAccount();
        $bankAccountPayee->setAccountNumber("0512-351217");
        $bankAccountPayee->setRoutingNumber("4271-04991");
        $bankAccountPayee->setBankName("Mikey National Bank");
        $bankAccountPayee->setBankAccountType(BankAccount::ACCOUNT_TYPE_CHECKING);

        $this->gateway = new ACHWorksWSGateway($this->getHttpClient(), $this->getHttpRequest());

        $this->gateway->setTestMode(true);
        $this->gateway->connectionCheck();

        $this->purchaseOptions = array(
            'amount' => '10.00',
            'bankAccountPayee' => $bankAccountPayee,

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
