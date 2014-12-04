<?php

namespace Omnipay\ACHWorks\Message;

use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;
use Omnipay\Omnipay;

class AchToAchtCreditTest extends ACHWorksTest
{

    public function setUp()
    {
        parent::setUp();

        $this->request = new AchToAchRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize(
            array(

                'amount' => '12.00',
                'bankAccountPayee' => $this->bankAccountPayee,
                'developerMode' => true,
                'CheckNumber' => '123',
                'memo' => 'PurchaseTest-ACHWorks',
                'SSS' => 'TST',
                'LocID' => '9505',
                'CompanyKey' => 'SASD%!%$DGLJGWYRRDGDDUDFDESDHDD',
                'Company' => 'MYCOMPANY',
                'TransactionType' => 'PPD',
                'OpCode' => 'S',
                'AccountSet' => '1',
                'Mode' => 'C'
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->request->setTestMode(true);

        // $response = $this->request->sendData($data);
        //    $this->assertEquals(true, $response->isSuccessful());
        // var_dump("achToAch", $data);

    }
}
