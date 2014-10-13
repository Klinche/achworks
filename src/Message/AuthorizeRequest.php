<?php

namespace Omnipay\ACHWorks\Message;

/**
 * ACHWorks Authorize Request
 */
class AuthorizeRequest extends AbstractRequest
{
    protected $action = 'AUTH_ONLY';

    public function getData()
    {
        $this->validate('amount');

        if ($card = $this->getCard()) {
            $card->validate();
        } elseif ($bankAccountPayee = $this->getBankAccount()) {
            $bankAccountPayee->validate();
        }
    }
}
