<?php

namespace Omnipay\ACHWorks\Message;

use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;

class ConnectionCheckRequestTest extends ACHWorksTest
{

    public function setUp()
    {

        parent::setUp();

        $this->request = new ConnectionCheckRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'developerMode' => true,
                'SSS' => 'TST',
                'LocID' => '9505',
                'CompanyKey' => 'SASD%!%$DGLJGWYRRDGDDUDFDESDHDD',
                'Company' => 'MYCOMPANY',
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->request->setTestMode(true);

        //    $response = $this->request->send($data);
        //    $this->assertEquals(true, $response->isSuccessful());

    }
}
