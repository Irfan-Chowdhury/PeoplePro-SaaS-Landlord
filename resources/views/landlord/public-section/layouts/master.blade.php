

<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <!-- Metas -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="LionCoders" />
    <meta name="csrf-token" content="CmSeExxpkZmScDB9ArBZKMGKAyzPqnxEriplXWrS">
    {{-- <link rel="icon" type="image/png" href="{{aseet('landlord/images/logo', $general_setting->site_logo)}}" /> --}}
    <!-- Document Title -->
    {{-- <title>{{$general_setting->meta_title ?? 'SalePro SAAS'}}</title> --}}
    <!-- Links -->
    {{-- <meta name="description" content="{{$general_setting->meta_description ?? 'Buy SalePro inventory management & POS SAAS php script'}}" />
    <meta property="og:url" content="{{url()->full()}}" />
    <meta property="og:title" content="{{$general_setting->og_title ?? 'SalePro SAAS'}}" />
    <meta property="og:description" content="{{$general_setting->og_description ?? 'Buy SalePro inventory management & POS SAAS php script'}}" />
    <meta property="og:image" content="{{url('/public/landlord/images/og-image')}}/{{$general_setting->og_image ?? 'saleprosaas.jpg'}}" /> --}}

    <!-- Bootstrap CSS -->
    <link href="{{asset('landlord/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="preload" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"></noscript>

    <!-- Plugins CSS -->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{asset('landlord/css/plugins.css')}}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{asset('landlord/css/plugins.css')}}"></noscript>

    <!-- common style CSS -->
    <link id="switch-style" href="{{url('landlord/css/common-style-light.css')}}" rel="stylesheet">

    <!-- google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    {{-- @if(isset($general_setting->fb_pixel_script))
    {!!$general_setting->fb_pixel_script!!}
    @endif --}}

    <title>@yield('public-title')</title>
    @stack('css')

</head>

<body>

    @include('landlord.public-section.partials.header')

    @yield('public-content')

    @include('landlord.public-section.partials.footer')


    <!--Scroll to top starts-->
    <a href="#" id="scrolltotop"><i class="ti-arrow-up"></i></a>
    <!--Scroll to top ends-->
    <div class="body__overlay"></div>


    <!--Plugin js -->
    <script src="{{ asset('landlord/js/plugin.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    <script src="{{ asset('vendor/jquery/jquery-ui.min.js') }}"></script>

    <!-- Sweetalert2 -->
    {{-- <script src="{{ asset('landlord/js/sweetalert2@11.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Main js -->
    <script src="{{ asset('landlord/js/main.js')}}"></script>


    {{-- <script>
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

    @if(!env('USER_VERIFIED'))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D0S4KHQ1D6"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-D0S4KHQ1D6');
    </script>
    @endif

    @if(env('PRODUCT_MODE')==='DEMO')
        <script>
            $('#light-theme').on('click',function(){
                var css = $('#switch-style').attr('href');
                css = css.replace('dark','light');
                $('#switch-style').attr("href", css);
            })

            $('#dark-theme').on('click',function(){
                var css = $('#switch-style').attr('href');
                css = css.replace('light','dark');
                $('#switch-style').attr("href", css);
            })
        </script>
    @endif

    @stack('scripts')
</body>
</html>

