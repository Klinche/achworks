<?php

namespace Omnipay\ACHWorks\Message;

/**
 * ACHWorks Authorize Request
 */
class AuthorizeRequest extends AbstractRequest
{
    protected $action = 'AUTH_ONLY';

    const ECHECK = "ECHECK";
    const CREDIT_CARD = "CC";

    public function getData()
    {
        $this->validate('amount');

        $data = $this->getBaseData();
        $data['x_customer_ip'] = $this->getClientIp();
        $data['x_cust_id'] = $this->getCustomerId();

        if ($card = $this->getCard()) {
            $card->validate();
            $data['x_card_num'] = $this->getCard()->getNumber();
            $data['x_exp_date'] = $this->getCard()->getExpiryDate('my');
            $data['x_card_code'] = $this->getCard()->getCvv();
            $data['x_method'] = self::CREDIT_CARD;
        } elseif ($bankAccount = $this->getBankAccount()) {
            $bankAccount->validate();
            $data['x_bank_aba_code'] = $this->getBankAccount()->getRoutingNumber();
            $data['x_bank_acct_num'] = $this->getBankAccount()->getAccountNumber();
            $data['x_bank_acct_type'] = $this->getBankAccount()->getBankAccountType();
            $data['x_bank_name'] = $this->getBankAccount()->getBankName();
            $data['x_bank_acct_name'] = $this->getBankAccount()->getName();
            $data['x_echeck_type'] = "WEB";
            $data['x_recurring_billing'] = "FALSE";//NEED when we set echeck_type is WEB or TEL
            $data['x_method'] = self::ECHECK;
        }


        if ($this->getTestMode()) {
            $data['x_test_request'] = 'TRUE';
        }

        return array_merge($data, $this->getBillingData());
    }
}
