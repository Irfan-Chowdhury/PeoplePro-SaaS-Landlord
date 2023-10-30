@extends('landlord.public-section.layouts.master')
@section('public-title', config('app.name').' | '.'Home')
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

    .rounded-image {
        width: 50px; /* Set the width of the container */
        height: 50px; /* Set the height of the container */
        border-radius: 50%; /* Make it a circle */
         /* Clip the image to the rounded shape */
    }

    .rounded-image img {
        width: 100%; /* Make the image fill the container */
        height: 100%; /* Make the image fill the container */
        object-fit: cover; /* Maintain aspect ratio and cover the container */
    }
</style>
@endpush



    <!--Header-->

    <section class="hero mt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center hero-text mb-5">
                    <h1 class="heading">{{$hero->heading}}</h1>
                    <h2 class="sub-heading light h5 mb-5">{{$hero->sub_heading}}</h2>
                    <a href="#packages" class="button lg style2">{{$hero->button_text}}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="hero-img">
        <img src="{{asset('landlord/images/hero/'.$hero->image)}}" alt=""/>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 text-center mb-5">
                    <h2 class="heading">{{ __('file.Testimonials') }}</h2>
                </div>
            </div>
            <div class="swiper mySwiper swiper-container-horizontal swiper-container-autoheight" style="border-bottom:1px solid #ddd">
                <div class="swiper-wrapper" style="height: 348px;">
                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide swiper-slide-active" style="width: 563px; margin-right: 50px;">
                        <div class="review">
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="review-text">
                                {!!$testimonial->description!!}
                            </div>
                            <div class="d-flex justify-content-start mt-3">
                                <div class="reviewer rounded-image p-2" style="margin-top: 0px">
                                    <img src="{{asset('landlord/images/testimonial')}}/{{$testimonial->image}}" alt="{{$testimonial->name}}" />
                                </div>
                                <div class="p-2">
                                    <span>{{$testimonial->name}}@if($testimonial->business_name), {{$testimonial->business_name}}@endif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
                <div class="swiper-nav-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"><i class="ti-arrow-right"></i></div>
                <div class="swiper-nav-prev swiper-button-disabled" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="true"><i class="ti-arrow-left"></i></div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
        </div>
    </section>


    @isset($module)
        <section id="features" class="">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3 text-center mb-5">
                        <h2 class="heading">{{$module->heading}}</h2>
                        <p class="lead mb-5">{{$module->sub_heading}}</p>
                    </div>
                    @foreach($module->moduleDetails as $module)
                    <div class="col-md-4">
                        <div class="feature">
                            <div class="icon m-auto mb-3">
                                <i class="{{$module->icon}}"></i>
                            </div>
                            <h3>{{$module->name}}</h3>
                            <p>{{$module->description}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endisset

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
                        @if($faq)
                            <h2 class="heading">{{$faq->heading}}</h2>
                            <p class="lead">{{$faq->sub_heading}}</p>
                        @else
                            <h2 class="heading">Frequently Asked Questions</h2>
                            <p class="lead">Have questions? we have answered common ones below.</p>
                        @endif
                    </div>
                    <div class="col-md-6 offset-md-3 mb-5">
                        @foreach($faq->faqDetails as $key => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="{{'heading'.$key}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse1">
                                    {{$faq->question}}
                            </button>
                            </h2>
                            <div id="collapse-{{ $key }}" class="accordion-collapse collapse" aria-labelledby="{{'heading'.$key}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!!$faq->answer!!}
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
                <h2 class="heading">@lang('file.Pricing plans')</h2>
                <ul class="nav nav-tabs pricing-tab" id="pricingTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly-tab-pane" type="button" role="tab" aria-controls="monthly-tab-pane" aria-selected="true">{{ trans('file.Monthly') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="yearly-tab" data-bs-toggle="tab" data-bs-target="#yearly-tab-pane" type="button" role="tab" aria-controls="yearly-tab-pane" aria-selected="false">{{ trans('file.Yearly') }} <span class="badge">
                            {{-- Save 20% --}}
                        </span></button>
                    </li>
                </ul>
            </div>
            <div class="d-none d-lg-flex d-xl-flex justify-content-between mb-5">
                @if ($packages)
                    <div class="col">
                        <div class="pricing">
                            <div class="sticker">
                                <div class="pricing-header">
                                    <span class="h3">@lang('file.Plan')</span>
                                </div>
                                <div class="price">
                                    <span class="h4">@lang('file.Price')</span>
                                </div>
                            </div>
                            <div class="pricing-details">
                                <p>{{trans('file.Free Trial')}}</p>
                                @foreach ($saasFeatures as $item)
                                    @php
                                        $delimiter = '-';
                                        if (strpos($item, '_') !== false) {
                                            $delimiter = '_';
                                        }
                                        $words = explode($delimiter, $item);
                                        $convertedString = implode(' ', array_map('ucfirst', $words));
                                    @endphp
                                    <p>{{ $convertedString }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @foreach ($packages as $key => $package)
                        <div class="col">
                            <div class="pricing">
                                <div class="sticker">
                                    <div class="pricing-header">
                                        <span class="h3">{{ $package->name }}</span>
                                    </div>
                                    <div class="price">
                                        <div>
                                            <span class="h4"><span class="currency-code">{{$generalSetting->currency_code}}</span> <span class="package-price" data-monthly="{{$package->monthly_fee}}" data-yearly="{{$package->yearly_fee}}">{{$package->monthly_fee}}/month</span></span><br>
                                            {{-- <button href="#customer-signup" data-free="{{$package->is_free_trial}}" data-package_id="{{$package->id}}" class="button style2 signup-btn">Sign Up</button> --}}
                                            <button  data-bs-toggle="modal" data-bs-target="#signupModal" data-free="{{$package->is_free_trial}}" data-package_id="{{$package->id}}" class="button style2 d-block w-100 signup-btn mt-2">Sign Up</button>

                                        </div>
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




    <!--Scroll to top starts-->
    <a href="#" id="scrolltotop"><i class="ti-arrow-up"></i></a>
    <!--Scroll to top ends-->
    <div class="body__overlay"></div>

    <!-- Customer Sign Up -->
    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="padding: 30px;">
                    <div class="col-md-8 offset-md-2">
                        <div class="text-center mb-3">
                            @if($tenantSignupDescription)
                                <h2 class="heading">{{$tenantSignupDescription->heading}}</h2>
                                <p class="lead mb-3">{{$tenantSignupDescription->sub_heading}}</p>
                            @else
                                <h2 class="regular">Customer Sign Up</h2>
                                <p class="lead mb-3">Peoplepro is packed with all the features you'll need to seamlessly run your business</p>
                            @endif
                        </div>
                        <form action="{{ route('customer.signup') }}" method="POST" class="form row customer-signup-form">
                            @csrf
                            <input type="hidden" name="created_by" value="customer">
                            <input type="hidden" name="is_free_trail">
                            <input type="hidden" name="is_new_tenant" value="1">
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

                            <div class="col-md-12 mt-3 d-none" id="paymentArea">
                                <label><strong>{{ trans('file.Payment Method') }} <small class="text-danger">*</small> : &nbsp;&nbsp; </strong></label>
                                @foreach ($paymentMethods as $item)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_method" value="{{ $item->payment_method }}">
                                        <label class="form-check-label">@lang("file.$item->title")</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="card-element" class="form-control">
                                </div>
                                <div class="card-errors" role="alert"></div>
                            </div>
                            <div class="col-12 mt-3">
                                <p id="waiting-msg mb-3"></p>
                                <input id="submitBtn" type="submit" class="button style1 d-block w-100" value="{{trans('file.Submit')}}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


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

    <!-- Contact -->
    <section id="contact" class="grey-bg">
        <div class="container mb-5">
            <div class="row">
                <div class="col-md-5">
                    <h3 class="heading mt-5">{{ __('file.Contact Us') }}</h3>
                    <p class="lead contact-details"><i class="fa fa-phone"></i>{{$generalSetting->phone}} </p>
                    <p class="lead contact-details"><i class="fa fa-envelope"></i>{{$generalSetting->email}}</p>
                    <hr>
                    <h3 class="heading">{{ __('file.Connect with Us') }}</h3>
                    <ul class="footer-social p-0 pt-3 pb-3">
                        @foreach($socials as $social)
                            <li>
                                <a href="{{$social->link}}"><i class="{{$social->icon}}"></i></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6 offset-md-1">
                    <form action="{{ route('landingPage.contactUsSubmit') }}" method="POST"  class="form contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input required class="form-control" type="text" name="name"  placeholder="Name..." >
                            </div>
                            <div class="col-md-6">
                                <input required class="form-control" type="text" name="phone"  placeholder="Contact Number..." >
                            </div>
                            <div class="col-md-12">
                                <input required class="form-control" type="email" name="public_email"  placeholder="Your Email..." >
                            </div>
                            <div class="col-md-12">
                                <input required class="form-control" type="text" name="subject"  placeholder="Subject..." >
                            </div>
                            <div class="col-md-12">
                                <textarea required class="form-control" name="message"  placeholder="Your Message" ></textarea>
                            </div>

                            <div class="col-12 mt-3">
                                <p id="waiting-msg mb-3"></p>
                                <input id="submit-btn" type="submit" class="button style2 d-block w-100" value="{{trans('file.Submit')}}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>

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
            let trailLimit = $(this).data('free');
            if (!trailLimit) {
                $('#paymentArea').removeClass('d-none');
                $('input[name=is_free_trail]').val(0);
            }else{
                $("#paymentArea").addClass("d-none");
                $('input[name=is_free_trail]').val(1);
            }

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


        $("#yearly-tab").on('click', function(){
            $('input[name=subscription_type]').val('yearly');
            $(".package-price").each(function(){
                var plan = $(this).data('yearly')+'/year';
                $(this).html(plan);
            })
        })
        $("#monthly-tab").on('click', function(){
            $('input[name=subscription_type]').val('monthly');
            $(".package-price").each(function(){
                var plan = $(this).data('monthly')+'/month';
                $(this).html(plan);
            })
        })

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
