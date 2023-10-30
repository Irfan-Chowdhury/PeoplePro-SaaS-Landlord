<?php

declare(strict_types=1);


namespace App\Http\traits;

use App\Models\Landlord\PaymentSetting;

trait PaymentTrait {

    public function paymentMethods() : array|object|string
    {
        $paymentSetting = PaymentSetting::latest()->first();
        $activePaymentMethods = [];
        if(isset($paymentSetting->active_payment_gateway)) {
            $activePaymentMethods = explode("," ,$paymentSetting->active_payment_gateway);
        }

        $paymentMethods = [
            (object)[
                'title' => 'Stripe',
                'payment_method' => 'stripe',
            ],
            (object)[
                'title' => 'Paypal',
                'payment_method' => 'paypal',
            ],
            (object)[
                'title' => 'Razorpay',
                'payment_method' => 'razorpay',
            ],
            (object)[
                'title' => 'Paystack',
                'payment_method' => 'paystack',
            ],
        ];

        foreach ($paymentMethods as $key => $value) {
            if(!in_array($value->payment_method, $activePaymentMethods)){
                unset($paymentMethods[$key]);
            }
        }
        return $paymentMethods;
    }
}
