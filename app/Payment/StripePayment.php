<?php

namespace App\Payment;

use App\Contracts\PaybleContract;
use App\Models\Landlord\Payment;
// use App\Traits\PaymentTrait;
use Exception;
use Stripe;

class StripePayment implements PaybleContract
{
    public function pay($tenantRequestData, $paymentRequestData) : object
    {
        $totalAmount = request()->session()->get('price');
        $this->stripe($totalAmount * 100, $paymentRequestData['stripeToken']);

        $payment = Payment::create([
            'package_id' => $tenantRequestData->package_id,
            'amount' => $totalAmount,
            'payment_method' => $tenantRequestData->payment_method,
            'status' => 'paid',
            'subscription_type' => $tenantRequestData->subscription_type,
            'data' => json_encode($paymentRequestData)
        ]);

        return $payment;
    }



    public function cancel()
    {
        // $this->orderCancel();
        // return response()->json('success');

        /*
        |----------------------------------------------------------
        | Store your data here.
        | This section is common for all. Suggest you to use Trait.
        |----------------------------------------------------------
        */
    }

    protected function stripe($totalAmount, $stripeToken)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => (int)implode(explode(',',$totalAmount)),
                "currency" => env('STRIPE_CURRENCY'),
                "source" => $stripeToken,
                "description" => "Stripe Payment Successfull."
        ]);
    }
}

?>
