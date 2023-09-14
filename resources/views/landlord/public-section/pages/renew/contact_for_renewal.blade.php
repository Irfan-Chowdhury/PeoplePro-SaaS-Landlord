@extends('landlord.public-section.layouts.master')

@section('public-content')
@push('css')
    <style>
    .loading-icon {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .loading-icon i {
        font-size: 40px;
        color: #333;
    }
</style>
@endpush


    <section class="hero mt-0 pt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 hero-text mb-5">

                    <form action="{{ route('renew_subscription') }}" method="POST"
                        class="renew-subscription-form">
                        @csrf
                        <h1 class="heading h2 text-center mt-4">@lang('file.Your subscription has expired!')</h1>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label><strong>{{ trans('file.Subscription Type') }} *</strong></label>
                                <div class="form-check">
                                    <input type="radio" name="subscription_type" value="monthly" class="form-check-input"
                                        id="subscription-type-1" checked>
                                    <label class="form-check-label" for="subscription-type-1">
                                        @lang('file.Monthly')
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="subscription_type" value="yearly" class="form-check-input"
                                        id="subscription-type-2">
                                    <label class="form-check-label" for="subscription-type-2">
                                        @lang('file.Yearly')
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label><strong>{{ trans('file.Packages') }} *</strong></label>
                                @foreach ($packages as $key => $package)
                                    <div class="form-check">
                                        <input type="radio" name="package_id" value="{{ $package->id }}" class="form-check-input">
                                        <label class="form-check-label">{{ $package->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-4 form-group">
                                <label><strong>{{ trans('file.Payment Method') }} *</strong></label>
                                @foreach ($paymentMethods as $item)
                                    <div class="form-check">
                                        <input type="radio" name="payment_method" value="{{ $item->payment_method }}" class="form-check-input">
                                        <label class="form-check-label">@lang("file.$item->title")</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-12">
                                <div class="input-group mt-3">
                                    <input class="form-control mt-0" type="text" name="tenant_id" required
                                        placeholder="Type your subdomain to renew..." aria-label="subdomain..."
                                        aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">{{ '@' . env('CENTRAL_DOMAIN') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <input id="submitBtn" type="submit" class="button style1 d-block w-100"
                                    value="{{ trans('file.Submit') }}">
                            </div>
                        </div>
                    </form>
                    {{-- @endif --}}

                </div>
                <!-- <div class="col-md-8 offset-md-2">
                    <img class="hero-img" src="images/preview.png" alt=""/>
                </div> -->
            </div>
        </div>
    </section>
@endsection


@push('scripts')

<script>
    (function ($) {
        "use strict";

        $("#submitBtn").click(function(event){
            simulateTimeConsumingTask();
        });


    })(jQuery);
</script>

<script>
    function showLoadingIcon() {
        $('#loading-icon').css('display', 'flex');
    }

    function hideLoadingIcon() {
        $('#loading-icon').css('display', 'none');
    }

    function simulateTimeConsumingTask() {
        showLoadingIcon(); // Show the loading icon before the task starts
        setTimeout(function () {
        }, 3000);
    }
</script>

@if ($errors->any())
    <script>
        $(document).ready(function() {
            hideLoadingIcon();
            let errorMessages = @json($errors->all());
            htmlContent = "";
            errorMessages.forEach(function(errorMsg) {
                htmlContent += '<p class="text-danger">' + errorMsg + '</p>';
            });
            console.log(htmlContent);
            displayErrorMessage(htmlContent);
        });
    </script>
@endif

@if(session()->has('success'))
    <script>
        $(document).ready(function() {
            hideLoadingIcon();
            displaySuccessMessage('{{ Session::get('success') }}');
        });
    </script>
@endif
<script type="text/javascript" src="{{ asset('js/landlord/common-js/alertMessages.js') }}"></script>
@endpush

