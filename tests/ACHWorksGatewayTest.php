<?php

namespace Omnipay\ACHWorks;

use Omnipay\Tests\GatewayTestCase;

class ACHWorksGateWayTest extends GatewayTestCase
{
    protected $voidOptions;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new ACHWorksWSGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setTestMode(true);
        $this->gateway->connectionCheck();

        $this->purchaseOptions = array(
            'amount' => '10.00',
            'card' => $this->getValidCard(),
        );

        $this->captureOptions = array(
            'amount' => '10.00',
            'transactionReference' => '12345',
        );

        $this->voidOptions = array(
            'transactionReference' => '12345',
        );
    }

}
