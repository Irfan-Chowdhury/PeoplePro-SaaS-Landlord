{{-- @php
    $generalSetting =  DB::table('general_settings')->latest()->first();
@endphp --}}

<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <!-- Metas -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="LionCoders" />
    <meta name="csrf-token" content="CmSeExxpkZmScDB9ArBZKMGKAyzPqnxEriplXWrS">
    {{-- <link rel="icon" type="image/png" href="{{url('public/landlord/images/logo', $general_setting->site_logo)}}" /> --}}
    <!-- Document Title -->
    {{-- <title>{{$general_setting->meta_title ?? 'PeoplePro SAAS'}}</title> --}}
    <title>PeoplePro SAAS</title>
    <!-- Links -->
    {{-- <meta name="description" content="{{$general_setting->meta_description ?? 'Buy SalePro inventory management & POS SAAS php script'}}" />
    <meta property="og:url" content="{{url()->full()}}" />
    <meta property="og:title" content="{{$general_setting->og_title ?? 'SalePro SAAS'}}" />
    <meta property="og:description" content="{{$general_setting->og_description ?? 'Buy SalePro inventory management & POS SAAS php script'}}" />
    <meta property="og:image" content="{{url('/public/landlord/images/og-image')}}/{{$general_setting->og_image ?? 'saleprosaas.jpg'}}" /> --}}

    <!-- Bootstrap CSS -->
    <link href="{{url('/')}}/landlord/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS-->
    <link rel="preload" href="<?php echo asset('../../vendor/font-awesome/css/font-awesome.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="<?php echo asset('../../vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet"></noscript>

    <!-- Plugins CSS -->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{url('/')}}/landlord/css/plugins.css">
    <noscript>
        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{url('/')}}/landlord/css/plugins.css">
    </noscript>

    <!-- common style CSS -->
    <link href="{{url('/')}}/landlord/css/common-style.css" rel="stylesheet">

    <!-- google fonts-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap">
    <noscript>
        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"
            href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;600&display=swap">
        </noscript>


    <style>
        :root {
            --theme-color: #f16232;
        }

        .pricing {
            background-color: #FFF;
            text-align: center;
        }
        .pricing-header {
            background-color: #733686;
            font-size: 24px;
            padding: 20px 15px;
        }
        .pricing-header .h3 {
            color: #FFF !important;
        }
        .pricing-details p {
            padding: 20px 15px;
        }
        .pricing-details p i {
            font-weight: bold;
        }
        .pricing-details p .ti-check {
            color: green
        }
        .pricing-details p .ti-close {
            color: red
        }
        .pricing-details p:nth-child(even) {
            background-color: #ececec;
        }
        .price {
            align-items: center;
            background-color: #FFF;
            display: flex;
            justify-content: center;
            min-height: 130px;
            padding: 20px 15px;
        }

        .pricing-m {
            background-color: #FFF;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .pricing-m .pricing-header {
            align-items: center;
            background-color: transparent;
            display: flex;
            font-size: 24px;
            padding: 15px;
            width: 70%;
        }
        .pricing-m .pricing-header .h3 {
            color: #141414 !important;
        }
        .pricing-m .price {
            min-height: 80px;
        }
        .pricing-m .price span {
            color: #2aa6de;
            display: block;
            font-size: 20px;
        }
        .currency-code {
            color: #666;
            font-size: 14px;
        }
        .pricing-m .pricing-details:first-child {
            width: 70%
        }
        .pricing-m .pricing-details:last-child {
            text-align: center;
            width: 30%
        }
        .pricing-m .signup {
            padding: 15px;
        }
        .custom-control {
            position: relative;
            z-index: 1;
            display: block;
            min-height: 1.5rem;
            padding-left: 1.5rem;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact;
        }
        .custom-control-input {
            position: absolute;
            left: 0;
            z-index: -1;
            width: 1rem;
            height: 1.25rem;
            opacity: 0;
        }
        .custom-switch {
            padding-left: 2.25rem;
        }
        .custom-control-label {
            position: relative;
            margin-bottom: 0;
            padding-left: 10px;
            vertical-align: top;
        }
        .custom-switch .custom-control-label::before {
            left: -2.25rem;
            width: 2rem;
            pointer-events: all;
            border-radius: .5rem;
        }
        .custom-control-label::before, .custom-file-label, .custom-select {
            transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        .custom-control-label::before {
            position: absolute;
            top: .25rem;
            left: -1.5rem;
            display: block;
            width: 2rem;
            height: 1rem;
            pointer-events: none;
            content: "";
            background-color: #fff;
            border: 1px solid #adb5bd;
        }
        .custom-switch .custom-control-label::after {
            top: calc(.25rem - 1px);
            left: calc(-2.25rem);
            width: calc(1.15rem);
            height: calc(1.15rem);
            background-color: #adb5bd;
            border-radius: .5rem;
            transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out;
            transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out;
        }
        .custom-control-label::after {
            position: absolute;
            top: .25rem;
            left: -1.5rem;
            display: block;
            width: 1rem;
            height: 1rem;
            content: "";
            background: 50%/50% 50% no-repeat;
            background-color: rgba(0, 0, 0, 0);
        }
        .custom-control-input:checked ~ .custom-control-label::before {
            color: #fff;
            border-color: #6d4bb0;
            background-color: #6d4bb0;
        }
        .custom-switch .custom-control-input:checked ~ .custom-control-label::after {
            background-color: #fff;
            left: calc(-2rem);
            -webkit-transform: translateX(.75rem);
            transform: translateX(.75rem);
        }
    </style>

    @stack('css')


    {{-- @if(isset($general_setting->fb_pixel_script))
    {!!$general_setting->fb_pixel_script!!}
    @endif --}}
</head>

<body>

    <header id="header-middle" class="header-middle">

        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-7">
                    <div class="mobile-menu-icon d-lg-none"><i class="ti-menu"></i></div>
                    <div class="logo">
                        <a href="{{url('/')}}">
                            <img class="lazy" src="{{asset('landlord/images/logo/'. $generalSetting->site_logo)}}">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-flex d-xl-flex middle-column justify-content-center">
                    <div id="main-menu" class="main-menu">
                        <ul class="pl-0">
                            <li><a href="{{url('/')}}#features">Features</a></li>

                            <li><a href="{{url('/')}}#faq">FAQ</a></li>

                            <li><a href="{{url('/')}}#packages">Pricing</a></li>

                            <li><a href="{{url('/blogs')}}">Blogs</a></li>
                            {{-- @if(count($languages) > 1)
                            <li class="d-lg-none dropdown">
                                <a class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Language
                                </a>
                                <div class="dropdown-menu">
                                @foreach($languages as $language)
                                    <a class="dropdown-item" href="{{url('switch-landing-page-language/'.$language->id)}}">{{$language->name}}</a>
                                @endforeach
                                </div>
                            </li>
                            @endif --}}
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-5" style="text-align:right">
                    <ul class="offset-menu-wrapper p-0 d-none d-lg-flex d-xl-flex">
                        @foreach($socials as $social)
                            <li>
                                <a href="{{$social->link}}"><i class="{{$social->icon}}"></i></a>
                            </li>
                        @endforeach
                        {{-- @if(count($languages) > 1)
                        <li class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Lang
                            </button>
                            <div class="dropdown-menu">
                                @foreach($languages as $language)
                                <a class="dropdown-item" style="line-height:1.5" href="{{url('switch-landing-page-language/'.$language->id)}}">{{$language->name}}</a>
                                @endforeach
                            </div>
                        </li>
                        @endif --}}
                        <li>
                            <a class="button style2" href="#packages">Try Now</a>
                        </li>
                    </ul>
                    <a class="button style2 d-lg-none" href="#packages">Try Now</a>
                </div>
            </div>
        </div>
        <nav id="mobile-nav"></nav>
    </header>
    @yield('public-content')

    <!-- Footer section Starts-->
    <div class="footer-wrapper pt-0">
        <div class="container">
            <div class="footer-links">
                @foreach($pages as $key => $page)
                    <a href="{{url('pages/'.$page->slug)}}">{{$page->title}} &nbsp; @if($key !== (count($pages)-1)) | @endif</a>
                @endforeach
            </div>
            <div class="footer-bottom">
                <ul class="footer-social p-0 pt-3 pb-3">
                    @foreach($socials as $social)
                    <li>
                        <a href="{{$social->link}}"><i class="{{$social->icon}}"></i></a>
                    </li>
                    @endforeach
                </ul>
                {{-- <p class="copyright">&copy; {{$general_setting->site_title}} {{date_format(date_create(date('Y-m-d')), $general_setting->date_format)}}. All rights reserved</p> --}}
            </div>
        </div>
    </div>
    <!-- Footer section Ends-->

    <!--Scroll to top starts-->
    <a href="#" id="scrolltotop"><i class="ti-arrow-up"></i></a>
    <!--Scroll to top ends-->

    <div class="body__overlay"></div>

    <!-- Cookie consent Starts-->


    <!-- Cookie consent Ends-->


    <!--Plugin js -->
    <script src="{{ asset('landlord/js/plugin.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    <!-- Sweetalert2 -->
    {{-- <script src="landlord/js/sweetalert2@11.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Main js -->
    <script src="{{ asset('landlord/js/main.js') }}"></script>
    {{-- <script type="text/javascript" src="https://js.stripe.com/v3/"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('js/payment/razorpay.js') }}"></script> --}}

    {{-- <script>
        let targetURL = "{{ url('/payment/razorpay/pay/confirm')}}";
        let cancelURL = "{{ url('payment/razorpay/pay/cancel')}}";
        let redirectURL = "{{ url('/payment_success')}}";
        let redirectURLAfterCancel = "{{ url('/payment_cancel')}}";

        $("div.alert").delay(3000).slideUp(800);
        var public_key = <?php echo json_encode($general_setting->stripe_public_key)?>;
        var active_payment_gateway = <?php echo json_encode($general_setting->active_payment_gateway)?>;
        (function ($) {
            "use strict";

            $(".card-element").hide();
            $(".card-errors").hide();

            $('.banner-slide-up').on('click', function () {
                $(this).parent().slideUp();
            });

            $(document).ready(function () {
                $('#newsletter-modal').modal('toggle');
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
            })

            $('input[name=tenant]').on('input', function () {
                var tenant = $(this).val();
                var letters = /^[a-zA-Z0-9]+$/;
                if(!letters.test(tenant)) {
                    alert('Tenant name must be alpha numeric(a-z and 0-9)!');
                    tenant = tenant.substring(0, tenant.length-1);
                    $('input[name=tenant]').val(tenant);
                }
            });

            $(document).on('submit', '.customer-signup-form', function(e) {
                $("#submit-btn").prop('disabled', true);
                $("p#waiting-msg").text("Please wait. It will take some few seconds. System will redirect you to the tenant url automatically.")
            });

            //Search field
            $('#search_field').hide();

            $(document).ready(function () {
                $('#searchText').keyup(function () {
                    var txt = $(this).val();
                    if (txt != '') {
                        $('#search_field').show();
                        $('#result').html('<li>loading...</li>');
                        $.ajax({
                            url: "data_ajax_search",
                            type: "GET",
                            data: {
                                search_txt: txt
                            },
                            success: function (data) {
                                $('#search_field').show();
                                $('#result').empty().html(data);
                            }
                        })
                    } else if (txt.length === 0) {
                        $('#search_field').hide();
                    } else {
                        $('#search_field').hide();
                        $('#result').empty();
                    }
                })
            });

            $('#stripeContent').hide();

            $(window).on('load', function () {

                $('.lazy').Lazy();
            });

        })(jQuery);
    </script> --}}
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>

    @if(isset($general_setting->ga_script))
    {!!$general_setting->ga_script!!}
    @endif

    @if(isset($general_setting->chat_script))
    {!!$general_setting->chat_script!!}
    @endif

    @if(env('USER_VERIFIED')==0)
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D0S4KHQ1D6"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-D0S4KHQ1D6');
    </script>
    @endif

    @stack('scripts')
</body>
</html>

