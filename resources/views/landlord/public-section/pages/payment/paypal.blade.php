@extends('landlord.public-section.layouts.master')
@section('public-content')
<div class="row">
    <div class="col-12">
        <h1 class="page-title h2 text-center uppercase mt-1 mb-5">@lang('file.Paypal')
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

                <form action="{{ route('payment.pay.process','paypal') }}" method="post" id="paypalPaymentForm">
                    <input type="hidden" name="tenantRequestData" value="{{ $tenantRequestData }}">
                    {{-- <input type="hidden" name="total_amount" value="{{ $totalAmount }}"> --}}
                    <input type="hidden" name="total_amount" value="1">

                    <div id="paypal-button-container"></div>

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

<script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_SANDBOX_CLIENT_ID')}}&currency=USD" data-namespace="paypal_sdk"></script>
<script type="text/javascript">
    let targetURL = "{{ url('/payment/stripe/pay/process')}}";
    let cancelURL = "{{ url('/payment/stripe/pay/cancel')}}";
    let redirectURL = "{{ url('/payment-success')}}";
    let redirectURLAfterCancel = "{{ url('/payment_cancel')}}";
</script>
<script type="text/javascript" src="{{ asset('js/landlord/payment/paypal.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/landlord/common-js/alertMessages.js') }}"></script>

@endpush
