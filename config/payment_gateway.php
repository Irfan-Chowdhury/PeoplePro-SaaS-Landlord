<?php

return [
    'stripe' => [
        'key' => env("STRIPE_KEY"),
        'secret' => env("STRIPE_SECRET"),
        'currency' => env("STRIPE_CURRENCY"),
    ],
    'paypal' => [
        'mode' => env("PAYPAL_MODE"),
        'client_id' => env("PAYPAL_SANDBOX_CLIENT_ID"),
        'client_secret' => env("PAYPAL_SANDBOX_CLIENT_SECRET"),
    ],
    'razorpay' => [
        'status' => env("RAZORPAY_STATUS"),
        'key' => env("RAZORPAY_KEY"),
        'secret' => env("RAZORPAY_SECRET"),
    ],
    'paystack' => [
        'key' => env("PAYSTACK_PUBLIC_KEY"),
        'secret' => env("PAYSTACK_SECRET_KEY"),
        'payment_url' => env("PAYSTACK_PAYMENT_URL"),
        'merchant_email' => env("MERCHANT_EMAIL"),
        'currency' => env("PAYSTACK_CURRENCY"),
    ],
];
