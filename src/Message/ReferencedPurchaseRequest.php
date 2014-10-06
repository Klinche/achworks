<?php

namespace Omnipay\ACHWorks\Message;

/**
 * ACHWorks Purchase Request
 */
class ReferencedPurchaseRequest extends RefundRequest
{
    public $transactionType = 'SALE';
}
