<?php

namespace Omnipay\ACHWorks\Message;

use Omnipay\Tests\TestCase;
use Omnipay\ACHWorks\BankAccount;
use Omnipay\ACHWorks;

class CheckCompanyStatusRequestTest extends ACHWorksTest
{

    public function setUp()
    {

        parent::setUp();

        $this->request = new CheckCompanyStatusRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(

            array(
                'amount' => '12.00',
                'bankAccountPayee' => $this->bankAccountPayee,
                'developerMode' => true,
                'memo' => 'PurchaseTest-ACHWorks',
                'SSS' => 'TST',
                'LocID' => '9505',
                'CompanyKey' => 'SASD%!%$DGLJGWYRRDGDDUDFDESDHDD',
                'Company' => 'MyCompany',
                'TransactionType' => 'PPD',
                'OpCode' => 'S',
                'AccountSet' => '1',
                'CheckNumber' => '123',

            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        //     $response = $this->request->sendData($data);

        // We fail because there is no valid $$ for this account
        //    $this->assertEquals(false, $response->isSuccessful());

    }
}
