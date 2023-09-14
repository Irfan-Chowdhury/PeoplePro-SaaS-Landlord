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
                            <option value="paypal" {{ in_array('paypal', $paymentGateWays) ? 'selected' : null }}>@lang('file.Paypal')</option>
                            <option value="razorpay" {{ in_array('razorpay', $paymentGateWays) ? 'selected' : null }}>@lang('file.Razorpay')</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <h5 class="font-weight-bold">@lang('file.Stripe Credentials')</h5>
                    <hr>
                </div>
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 6,
                    'labelName' => 'Stripe Publishable key',
                    'fieldType' => 'text',
                    'nameData' => 'stripe_public_key',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> isset($paymentSetting->stripe_public_key) ? $paymentSetting->stripe_public_key : null
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 6,
                    'labelName' => 'Stripe Secret key',
                    'fieldType' => 'text',
                    'nameData' => 'stripe_secret_key',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> isset($paymentSetting->stripe_secret_key) ? $paymentSetting->stripe_secret_key : null
                ])

                <div class="col-md-12">
                    <h5 class="font-weight-bold">@lang('file.Paystack Credentials')</h5>
                    <hr>
                </div>
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 6,
                    'labelName' => 'Paystack Publishable key',
                    'fieldType' => 'text',
                    'nameData' => 'paystack_public_key',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> isset($paymentSetting->paystack_public_key) ? $paymentSetting->paystack_public_key : null
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 6,
                    'labelName' => 'Paystack Secret key',
                    'fieldType' => 'text',
                    'nameData' => 'paystack_secret_key',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> isset($paymentSetting->paystack_secret_key) ? $paymentSetting->paystack_secret_key : null
                ])

                <div class="col-md-12">
                    <h5 class="font-weight-bold">@lang('file.Paypal Credentials')</h5>
                    <hr>
                </div>
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 6,
                    'labelName' => 'Paypal Client ID',
                    'fieldType' => 'text',
                    'nameData' => 'paypal_client_id',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> isset($paymentSetting->paypal_client_id) ? $paymentSetting->paypal_client_id : null
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 6,
                    'labelName' => 'Paypal Client Secret',
                    'fieldType' => 'text',
                    'nameData' => 'paypal_client_secret',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> isset($paymentSetting->paypal_client_secret) ? $paymentSetting->paypal_client_secret : null
                ])
                <div class="col-md-12">
                    <h5 class="font-weight-bold">@lang('file.Razorpay Credentials')</h5>
                    <hr>
                </div>
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Razorpay Number',
                    'fieldType' => 'number',
                    'nameData' => 'razorpay_number',
                    'placeholderData' => '123456789',
                    'isRequired' => false,
                    'valueData'=> isset($paymentSetting->razorpay_number) ? $paymentSetting->razorpay_number : null
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Razorpay Key',
                    'fieldType' => 'text',
                    'nameData' => 'razorpay_key',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> isset($paymentSetting->razorpay_key) ? $paymentSetting->razorpay_key : null
                ])
                @include('landlord.super-admin.partials.input-field',[
                    'colSize' => 4,
                    'labelName' => 'Razorpay Secret',
                    'fieldType' => 'text',
                    'nameData' => 'razorpay_secret',
                    'placeholderData' => 'pk_test_ITN7XXXXXXXXXXXXXXXXXXXX',
                    'isRequired' => false,
                    'valueData'=> isset($paymentSetting->razorpay_secret) ? $paymentSetting->razorpay_secret : null
                ])

            </div>
            <div class="form-group row mt-3">
                <button type="submit" id="paymentButton" class="btn btn-primary btn-block">@lang('file.Submit')</button>
            </div>
        </form>
    </div>
</div>
</div>
