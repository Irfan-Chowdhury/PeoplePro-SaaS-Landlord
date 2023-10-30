<div class="tab-pane fade" id="paymentSetting" role="tabpanel" aria-labelledby="payment-setting">    <div class="card">
    <h4 class="card-header p-3"><b>@lang('file.Payment Setting')</b></h4>
    <hr>
    <div class="card-body">
        <form id="paymentSettingSubmit" action="{{ route('setting.payment.manage') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="font-weight-bold">{{trans('file.Active Payment Gateway')}}</label>
                    <select name="active_payment_gateway[]" class="selectpicker form-control"
                            data-live-search="true" data-live-search-style="contains" multiple
                            title='{{__('Selecting',['key'=>trans('file.No Payment Gateway')])}}...'>
                            <option value="stripe" {{ in_array('stripe', $paymentGateWays) ? 'selected' : null }}>@lang('file.Stripe')</option>
                            <option value="paystack" {{ in_array('paystack', $paymentGateWays) ? 'selected' : null }}>@lang('file.Paystack')</option>
                            {{-- <option value="paypal" {{ in_array('paypal', $paymentGateWays) ? 'selected' : null }}>@lang('file.Paypal')</option> --}}
                            <option value="razorpay" {{ in_array('razorpay', $paymentGateWays) ? 'selected' : null }}>@lang('file.Razorpay')</option>
                    </select>
                </div>

                <!-- Stripe -->
                <div class="col-md-12 mt-4">
                    <h5 class="font-weight-bold">@lang('file.Stripe Credentials')</h5>
                    <hr>
                </div>
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Stripe Publishable key',
                    'fieldType' => 'text',
                    'nameData' => 'stripe_public_key',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.stripe.key')
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Stripe Secret key',
                    'fieldType' => 'text',
                    'nameData' => 'stripe_secret_key',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.stripe.secret')
                ])

                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Stripe Currency',
                    'fieldType' => 'text',
                    'nameData' => 'stripe_currency',
                    'placeholderData' => 'inr',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.stripe.currency')
                ])

                <!-- Paypal -->
                {{-- <div class="col-md-12 mt-4">
                    <h5 class="font-weight-bold">@lang('file.Paypal Credentials')</h5>
                    <hr>
                </div>
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Paypal Mode',
                    'fieldType' => 'text',
                    'nameData' => 'paypal_mode',
                    'placeholderData' => 'sandbox',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.paypal.mode')
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Paypal Client ID',
                    'fieldType' => 'text',
                    'nameData' => 'paypal_client_id',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.paypal.client_id')
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Paypal Client Secret',
                    'fieldType' => 'text',
                    'nameData' => 'paypal_client_secret',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.paypal.client_secret')
                ]) --}}


                <!-- Paystack -->
                <div class="col-md-12 mt-4">
                    <h5 class="font-weight-bold">@lang('file.Paystack Credentials')</h5>
                    <hr>
                </div>
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Paystack Publishable key',
                    'fieldType' => 'text',
                    'nameData' => 'paystack_public_key',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.paystack.key')
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Paystack Secret key',
                    'fieldType' => 'text',
                    'nameData' => 'paystack_secret_key',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.paystack.secret')
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Paystack Payment URL',
                    'fieldType' => 'text',
                    'nameData' => 'paystack_payment_url',
                    'placeholderData' => 'https://api.paystack.co',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.paystack.payment_url')
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Paystack Merchant Email',
                    'fieldType' => 'text',
                    'nameData' => 'paystack_merchant_email',
                    'placeholderData' => 'unicodeveloper@gmail.com',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.paystack.merchant_email')
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Paystack Currency',
                    'fieldType' => 'text',
                    'nameData' => 'paystack_currency',
                    'placeholderData' => 'NGN',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.paystack.currency')
                ])

                <!-- Razorpay -->
                <div class="col-md-12 mt-4">
                    <h5 class="font-weight-bold">@lang('file.Razorpay Credentials')</h5>
                    <hr>
                </div>

                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 6,
                    'labelName' => 'Razorpay Key',
                    'fieldType' => 'text',
                    'nameData' => 'razorpay_key',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.razorpay.key')
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 6,
                    'labelName' => 'Razorpay Secret',
                    'fieldType' => 'text',
                    'nameData' => 'razorpay_secret',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> config('payment_gateway.razorpay.secret')
                ])

            </div>
            <div class="form-group row mt-3">
                <button type="submit" id="paymentButton" class="btn btn-primary btn-block">@lang('file.Submit')</button>
            </div>
        </form>
    </div>
</div>
</div>
