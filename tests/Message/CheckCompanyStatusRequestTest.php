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
    //    var_dump("TEST MODE", $data);

    //    $this->assertSame('TST', $data->InpCompanyInfo->SSS);
    }



}
