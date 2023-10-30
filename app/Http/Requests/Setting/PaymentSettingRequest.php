<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules() : array
    {
        $rules = [];

        if (empty($this->active_payment_gateway)) {
            $rules['active_payment_gateway'] = 'required|string|min:3';
        }
        else {
            if (in_array("stripe", $this->active_payment_gateway) || ($this->stripe_public_key || $this->stripe_secret_key || $this->stripe_currency)) {
                $rules['stripe_public_key'] = 'required|string|min:3';
                $rules['stripe_secret_key'] = 'required|string|min:3';
                $rules['stripe_currency'] = 'required|string';
            }

            if(in_array("paystack", $this->active_payment_gateway) || ($this->paystack_public_key || $this->paystack_secret_key || $this->paystack_payment_url || $this->paystack_merchant_email || $this->paystack_currency)) {
                $rules['paystack_public_key'] = 'required|string|min:3';
                $rules['paystack_secret_key'] = 'required|string|min:3';
                $rules['paystack_payment_url'] = 'required|url';
                $rules['paystack_merchant_email'] = 'required|email:filter';
                $rules['paystack_currency'] = 'required|string';
            }

            if(in_array("paypal", $this->active_payment_gateway) || ($this->paypal_client_id || $this->paypal_client_secret)) {
                $rules['paypal_client_id'] = 'required|string|min:3';
                $rules['paypal_client_secret'] = 'required|string|min:3';
            }

            if(in_array("razorpay", $this->active_payment_gateway) || ($this->razorpay_key || $this->razorpay_secret)) {
                $rules['razorpay_key'] = 'required|string|min:3';
                $rules['razorpay_secret'] = 'required|string|min:3';
            }
        }

        return $rules;
    }
}
