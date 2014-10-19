<?php

namespace Omnipay\ACHWorks\Message;

use Omnipay\Tests\TestCase;
use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;

class GetACHReturnsRequestTest extends ACHWorksTest
{

    public function setUp()
    {

        parent::setUp();

        $this->request = new GetACHReturnsRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(

            array(
                'developerMode' => true,
                'memo' => 'PurchaseTest-ACHWorks',
                'SSS' => 'TST',
                'LocID' => '9505',
                'CompanyKey' => 'SASD%!%$DGLJGWYRRDGDDUDFDESDHDD',
                'Company' => 'MyCompany',
              )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);

        /** @var \Omnipay\ACHWorks\Message\Response $response */
        $msg = $response->getMessage();
        var_dump("GetACHReturnsTest:", $msg);
        // We fail because there is no valid $$ for this account
    //    $this->assertEquals(false, $response->isSuccessful());

    }
}
