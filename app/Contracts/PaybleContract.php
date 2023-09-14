<?php

namespace App\Contracts;

interface PaybleContract
{
    public function pay($tenantRequestData, $paymentRequestData);
    public function cancel();
}
