<?php

namespace App\Http\traits;

trait PaymentTrait {

    public function paymentMethods() : array
    {
        return [
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
            // (object)[
            //     'title' => 'Cash On Delivery',
            //     'payment_method' => 'cash_on_delivery',
            // ],
            // (object)[
            //     'title' => 'Other',
            //     'payment_method' => 'other',
            // ]
        ];
    }
}
