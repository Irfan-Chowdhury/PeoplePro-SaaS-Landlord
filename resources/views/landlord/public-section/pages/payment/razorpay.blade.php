@extends('landlord.public-section.layouts.master')
@section('public-title', config('app.name').' | '.'Razorpay')

@section('public-content')
<div class="row">
    <div class="col-12">
        <h1 class="page-title h2 text-center uppercase mt-1 mb-5">@lang('file.Razorpay')
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

                @if($message = Session::get('error'))
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <form action="{{ route('payment.pay.process','razorpay') }}" method="post" id="razorpayPaymentForm">
                    @csrf
                    <input type="hidden" name="tenantRequestData" value="{{ $tenantRequestData }}">
                    <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">

                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="{{ config('payment_gateway.razorpay.key') }}"
                        data-amount="{{ $totalAmount * 100 }}"
                        data-name=""
                        data-description="Razorpay"
                        data-image="http://peopleprosaas.test/landlord/images/logo/202309060239041.png"
                        data-prefill.name="name"
                        data-prefill.email="email"
                        data-theme.color="#ff7529">
                    </script>

                    <div class="mt-4 d-grid gap-2 mx-auto">
                        <button type="submit" id="payNowBtn" class="btn btn-outline-success">
                            @lang('file.Pay Now')
                            <small>
                                {{ number_format((float)$totalAmount, 2, '.', '') }}
                            </small>
                        </button>
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
<script type="text/javascript">
    let targetURL = "{{ url('/payment/stripe/pay/process')}}";
    let cancelURL = "{{ url('/payment/stripe/pay/cancel')}}";
    let redirectURL = "{{ url('/payment-success')}}";
    let redirectURLAfterCancel = "{{ url('/payment_cancel')}}";
</script>
<script type="text/javascript" src="{{ asset('js/landlord/payment/razorpay.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/landlord/common-js/alertMessages.js') }}"></script>

@endpush
