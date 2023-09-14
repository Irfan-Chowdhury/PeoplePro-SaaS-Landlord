@extends('landlord.public-section.layouts.master')
@section('public-content')
<div class="row">
    <div class="col-12">
        <h1 class="page-title h2 text-center uppercase mt-1 mb-5">@lang('file.Stripe')
            <small>
                ({{ number_format((float)$totalAmount, 2, '.', '') }})
            </small>
        </h1>
    </div>
</div>


<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid" id="errorMessage"></div>

                <form class="mb-3 require-validation" id="stripePaymentForm" data-cc-on-file="false" action="{{ route('payment.pay.process','stripe') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tenantRequestData" value="{{ $tenantRequestData }}">
                    <input type="hidden" id="stripeKey" value="{{env('STRIPE_KEY')}}">
                    <input type="hidden" name="stripeToken">


                    <div class='row'>
                        <div class='col-md-12 form-group'>
                            <input class='form-control' size='4' type='text' name="card_name" placeholder="@lang('file.Name on Card')" value="Test">
                        </div>
                    </div>

                    <div class='form-row row'>
                        <div class='col-xs-12 form-group'>
                            <input type="number" autocomplete='off' name="card_number" class='form-control card-number' placeholder="@lang('file.Card Number')" size='20' type='text' value="4242424242424242">
                        </div>
                    </div>

                    <div class='form-row row'>
                        <div class='col-xs-12 col-md-4 form-group cvc'>
                            <input type="number" autocomplete='off' name="card-cvc" class='form-control card-cvc' size='4' type='text' placeholder="CVC (ex. 311)" value="311">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration'>
                            <input type="number" min="1" max="12" class='form-control card-expiry-month' name="card-expiry-month" size='2' type='text' placeholder="Expiration Month (MM)" value="12">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration'>
                            <input  type="number" class='form-control card-expiry-year' name="card-expiry-year" placeholder='Expiration Year (YYYY)' size='4' type='text' value="2025">
                        </div>
                    </div>
                    <div class="mt-4 d-grid gap-2 mx-auto">
                        <button type="submit" id="payNowBtn" class="btn btn-outline-success">Pay Now</button>
                    </div>
                    <div class="mt-3 d-grid gap-2 mx-auto">
                        <button type="button" id="payCancelBtn" class="btn btn-outline-danger">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    let targetURL = "{{ url('/payment/stripe/pay/process')}}";
    let cancelURL = "{{ url('/payment/stripe/pay/cancel')}}";
    let redirectURL = "{{ url('/payment-success')}}";
    let redirectURLAfterCancel = "{{ url('/payment_cancel')}}";
</script>
<script type="text/javascript" src="{{ asset('js/landlord/payment/stripe.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/landlord/common-js/alertMessages.js') }}"></script>

@endpush
