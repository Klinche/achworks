<?php

namespace Omnipay\ACHWorks\Message;

use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;
use Omnipay\Omnipay;

class PurchaseRequestTest extends ACHWorksTest
{

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize(
            array(
                'amount' => '12.00',
                'bankAccount' => $this->bankAccount,
                'developerMode' => true,
                'memo'=> 'PurchaseTest-ACHWorks',
                'SSS' => 'TST',
                'LocID' => '9505',
                'CompanyKey' => 'SASD%!%$DGLJGWYRRDGDDUDFDESDHDD',
                'Company' => 'My Company',
                'TransactioNType' => 'PPD',
                'OpCode' => 'S',
                'AccountSet' => '1',
           )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->request->setTestMode(true);

   //     $resp= $this->request->sendData($data);

      }
}
