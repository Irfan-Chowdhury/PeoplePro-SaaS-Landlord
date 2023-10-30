<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    protected $fillable  = [
        'active_payment_gateway',

        'stripe_public_key',
        'stripe_secret_key',
        'stripe_currency',

        'paystack_public_key',
        'paystack_secret_key',

        'paypal_client_id',
        'paypal_client_secret',

        'razorpay_number',
        'razorpay_key',
        'razorpay_secret',
    ];
}
