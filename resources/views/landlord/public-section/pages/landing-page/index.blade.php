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



    <!--Header-->
    <!--Header Area starts-->
    @if(!env('USER_VERIFIED'))
    <div class="d-block text-center"><a class="button style1 w-100" href="https://lion-coders.com/software/salepro-saas">Buy Salepro SAAS</a></div>
    @endif

    <section class="hero mt-0">
        <div class="container">
            <div id="loading-icon" class="loading-icon">
                <i class="fa fa-spinner fa-spin"></i> Processing...
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center hero-text mb-5">
                    <h1 class="heading">{{$hero->heading}}</h1>
                    <h2 class="light h5 mb-3">{{$hero->sub_heading}}</h2>
                    <a href="#packages" class="button style1">{{$hero->button_text}}</a>
                </div>
                <div class="col-md-8 offset-md-2">
                    <img class="hero-img" src="{{asset('landlord/images/hero/'.$hero->image)}}" alt=""/>
                </div>
            </div>
        </div>
    </section>



    <section id="features" class="">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 text-center mb-5">
                    <h2 class="regular">{{$module->heading}}</h2>
                    <p class="lead mb-5">{{$module->sub_heading}}</p>
                </div>
                <div class="col-md-5">
                    @if(isset($module) && $module->image)
                        <img class="mb-5" src="{{asset('landlord/images/module/'.$module->image)}}" alt="Module image"/>
                    @else
                        <img class="mb-5" src="landlord/images/preview.png" alt=""/>
                    @endif
                </div>
                <div class="col-md-6 offset-md-1">
                    <div class="row">
                        @foreach($module->moduleDetails as $module)
                        <div class="col-md-6 feature">
                            <div class="icon">
                                <i class="{{$module->icon}}"></i>
                            </div>
                            <h3>{{$module->name}}</h3>
                            <p>{{$module->description}}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(count($features) > 0)
    <section class="grey-bg">
        <div class="container">
            <div class="row">
                @foreach($features as $feature)
                <div class="col-md-3 feature2">
                    <div class="icon">
                        <i class="{{$feature->icon}}"></i>
                    </div>
                    <h4 class="h6">{{$feature->name}}</h4>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(isset($faq))
        <section id="faq" class="accordion pb-0" id="accordionExample">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3 text-center mb-5">
                        <h2 class="regular">{{$faq->heading}}</h2>
                        <p class="lead">{{$faq->sub_heading}}</p>
                    </div>
                    <div class="col-md-6 offset-md-3 mb-5">
                        @foreach($faq->faqDetails as $key => $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse1">
                                    {{$item->question}}
                                </button>
                                </h2>
                                <div id="collapse-{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!!$item->answer!!}
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif



    <!-- Pricing Plan -->

    <section id="packages"class="grey-bg">
        <div class="container">
            <div class="col-md-6 offset-md-3 text-center mb-5">
                <h2 class="regular">@lang('file.Pricing plans')</h2>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="plan_type">
                    <label class="custom-control-label" for="plan_type">@lang('file.Show Yearly Price')</label>
                </div>
            </div>
            <div class="d-none d-lg-flex d-xl-flex justify-content-between mb-5">
                @if ($packages)
                    <div class="col">
                        <div class="pricing">
                            <div class="pricing-header">
                                <span class="h3">@lang('file.Plan')</span>
                            </div>
                            <div class="price">
                                <span class="h4">@lang('file.Price')</span>
                            </div>
                            <div class="pricing-details">
                                <p class="bold">{{trans('file.Free Trial')}}</p>
                                @foreach ($saasFeatures as $item)
                                    @php
                                        $delimiter = '-';
                                        if (strpos($item, '_') !== false) {
                                            $delimiter = '_';
                                        }
                                        $words = explode($delimiter, $item);
                                        $convertedString = implode(' ', array_map('ucfirst', $words));
                                    @endphp
                                    <p class="bold">{{ $convertedString }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @foreach ($packages as $key => $package)
                        <div class="col">
                            <div class="pricing">
                                <div class="pricing-header">
                                    <span class="h3">{{ $package->name }}</span>
                                </div>
                                <div class="price">
                                    <div>
                                        <span class="h4"><span class="currency-code">{{$generalSetting->currency_code}}</span> <span class="package-price" data-monthly="{{$package->monthly_fee}}" data-yearly="{{$package->yearly_fee}}">{{$package->monthly_fee}}/month</span></span><br>
                                        <button href="#customer-signup" data-free="{{$package->is_free_trial}}" data-package_id="{{$package->id}}" class="button style2 signup-btn">Sign Up</button>
                                    </div>
                                </div>
                                <div class="pricing-details">

                                    @if($package->is_free_trial)
                                        <p>{{ $generalSetting->free_trial_limit }} days</p>
                                    @else
                                        <p>N/A</p>
                                    @endif

                                    @php
                                        $selectedFeatures = explode(',',$package->features);
                                    @endphp

                                    @foreach ($saasFeatures as $item)
                                        @if(in_array($item, $selectedFeatures))
                                            <p><i class="ti-check"></i></p>
                                        @else
                                            <p><i class="ti-close"></i></p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <section class="grey-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 text-center mb-5">
                    <h2 class="regular">{{ __('file.Testimonials') }}</h2>
                </div>
            </div>
            <div class="swiper mySwiper swiper-container-horizontal swiper-container-autoheight">
                <div class="swiper-wrapper" style="height: 348px;">
                @forelse($testimonials as $testimonial)
                    <div class="swiper-slide swiper-slide-active" style="width: 563px; margin-right: 50px;">
                        <div class="review">
                            <div class="review-text">
                                {!!$testimonial->description!!}
                            </div>
                            <div class="reviewer"><img src="{{asset('landlord/images/testimonial')}}/{{$testimonial->image}}" alt="{{$testimonial->name}}" /> {{$testimonial->name}}@if($testimonial->business_name), {{$testimonial->business_name}}@endif</div>
                        </div>
                    </div>
                @empty
                @endforelse
                </div>
                <div class="swiper-nav-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"><i class="ti-arrow-right"></i></div>
                <div class="swiper-nav-prev swiper-button-disabled" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="true"><i class="ti-arrow-left"></i></div>
                <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span></div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
        </div>
    </section>

    <section id="customer-signup">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 text-center mb-3">
                    @if($tenantSignupDescription)
                        <h2 class="regular">{{$tenantSignupDescription->heading}}</h2>
                        <p class="lead mb-3">{{$tenantSignupDescription->sub_heading}}</p>
                    @else
                        <h2 class="regular">Customer Sign Up</h2>
                        <p class="lead mb-3">Peoplepro is packed with all the features you'll need to seamlessly run your business</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6 offset-md-3 mb-5">
                <form action="{{ route('customer.signup') }}" method="POST"  class="form row customer-signup-form">
                    @csrf
                    <input type="hidden" name="package_id">
                    <input type="hidden" name="subscription_type" value="monthly">
                    <input type="hidden" name="price">

                    <div class="col-6">
                        <input class="form-control" type="text" name="first_name"  placeholder="First Name..." required>
                    </div>
                    <div class="col-6">
                        <input class="form-control" type="text" name="last_name"  placeholder="Last Name..." required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="number" name="contact_no"  placeholder="Contact Number..." required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="email" name="email"  placeholder="Email..." required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="username"  placeholder="Username..." required>
                    </div>
                    <div class="col-6">
                        <input class="form-control" type="text" name="company_name"  placeholder="Company Name..." required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="password" name="password"  placeholder="Password..." required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="password" name="password_confirmation"  placeholder="Confirm Password..." required>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mt-3">
                            <input required class="form-control mt-0" type="text" name="tenant"  placeholder="Subdomain..." aria-label="ubdomain..." aria-describedby="basic-addon2">
                          <span class="input-group-text" id="basic-addon2">{{'@'.env('CENTRAL_DOMAIN')}}</span>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="card-element" class="form-control">
                        </div>
                        <div class="card-errors" role="alert"></div>
                    </div>
                    <div class="col-12 mt-3">
                        <p id="waiting-msg mb-3"></p>
                        <input id="submitBtn" type="submit" class="button style1 d-block w-100" value="{{trans('file.submit')}}">
                    </div>
                </form>
            </div>
        </div>
    </section>

    @if(count($blogs) > 0)
    <section id="blog">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 text-center mb-5">
                    <h2 class="regular">{{ __('file.Blog') }}</h2>
                </div>
                @foreach($blogs as $blog)
                <div class="col-md-4">
                    <a href="{{ route('landingPage.blogDetail',$blog->slug) }}">
                        <img src="{{asset('landlord/images/blog')}}/{{$blog->image}}" alt="{{$blog->title}}"/>
                        <h4 class="mt-3">{{$blog->title}}</h4>
                    </a>
                </div>
                @endforeach
                <div class="col-md-6 offset-md-3 text-center mt-3 mb-5">
                    <a href="{{url('blogs')}}" class="button style1">{{ __('file.All Blogs') }}</a>
                </div>
            </div>
        </div>

    </section>
    @endif

    {{-- @if(env('USER_VERIFIED')==0)
    <section class="pt-5">
        <div class="container">
            <div class="place-cta row">
                <div class="col-md-8">
                    <h3 class="regular h3 white-txt">Start your software business today. Buy SalePro SAAS</h3>
                </div>
                <div class="col-md-3 offset-md-1">
                    <div class="d-flex  justify-content-center">
                        <a class="button lg style3 mt-3" href="https://lion-coders.com/sale-pro-saas-purchase">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif --}}

@endsection





@push('scripts')

<script>
    (function ($) {
        "use strict";

        $("#plan_type").change(function(){
            if($("#plan_type").is(':checked')){
                $('input[name=subscription_type]').val('yearly');

                $(".package-price").each(function(){
                    var plan = $(this).data('yearly')+'/year';
                    $(this).html(plan);
                })
            }
            else {
                $('input[name=subscription_type]').val('monthly');
                $(".package-price").each(function(){
                    var plan = $(this).data('monthly')+'/month';
                    $(this).html(plan);
                })
            }
        });

        $(".signup-btn").on("click", function () {
            $('input[name=package_id]').val($(this).data('package_id'));
            if($('input[name=subscription_type]').val() == 'monthly') {
                $('input[name=price]').val($(this).parent().parent().find('.package-price').data('monthly'));
            } else {
                $('input[name=price]').val($(this).parent().parent().find('.package-price').data('yearly'));
            }
            $('html, body').animate({
                scrollTop: $("#customer-signup").offset().top
            });
        });

        $("#submitBtn").click(function(event){
            // event.preventDefault();

            // Call the function to start the task
            simulateTimeConsumingTask();
        });

        // simulateTimeConsumingTask();

        // Function to show the loading icon


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
