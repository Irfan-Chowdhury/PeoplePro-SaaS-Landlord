<?php

namespace App\Payment;

use App\Contracts\PaybleContract;
use App\Models\Landlord\Payment;
use Razorpay\Api\Api;


class RazorpayPayment implements PaybleContract
{
    public function pay($tenantRequestData, $paymentRequestData)
    {
        $input = $paymentRequestData;
        $api = new Api (env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $razorPayment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input) && !empty($input['razorpay_payment_id'])) {
            $razorpayResponse = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $razorPayment['amount']));

            $totalAmount = request()->session()->get('price');

            $payment = Payment::create([
                'package_id' => $tenantRequestData->package_id,
                'amount' => $totalAmount,
                'payment_method' => $tenantRequestData->payment_method,
                'status' => 'paid',
                'subscription_type' => $tenantRequestData->subscription_type,
                // 'data' => json_encode($paymentRequestData)
                'data' => json_encode(array_merge($paymentRequestData, ['razorpayResponse' => (array)$razorpayResponse]))
            ]);
        }

        return $payment;
    }

    public function cancel()
    {

    }
}
