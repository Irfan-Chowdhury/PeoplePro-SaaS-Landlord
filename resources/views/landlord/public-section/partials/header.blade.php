@if(env('PRODUCT_MODE')==='DEMO')
    <div class="notice">
        <a target="_blank" href="https://lion-coders.com/software/salepro-saas">Buy PeoplePro SAAS with full source code</a>
    </div>
@endif

@if(env('PRODUCT_MODE')==='DEMO')
    <div style="position:fixed;right:0;top:200px;z-index:99">
        <span id="light-theme" class="btn btn-light d-block"><i class="fa fa-sun-o"></i></span>
        <span id="dark-theme" class="btn btn-dark d-block"><i class="fa fa-moon-o"></i></span>
    </div>
@endif

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
                        <li><a href="{{url('/')}}#features">@lang('file.Features')</a></li>
                        <li><a href="{{url('/')}}#faq">@lang('file.FAQ')</a></li>
                        <li><a href="{{url('/')}}#packages">@lang('file.Pricing')</a></li>
                        <li><a href="{{url('/')}}#contact">@lang('file.Contact Us')</a></li>
                        <li><a href="{{url('/blogs')}}">@lang('file.Blogs')</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-5" style="text-align:right">
                <ul class="offset-menu-wrapper p-0 d-none d-lg-flex d-xl-flex">
                    <li class="has-dropdown">
                        <i class="fa fa-globe" aria-hidden="true"></i> {{ Session::has('TempPublicLocale') ? strtoupper(Session::get('TempPublicLocale')) : 'EN'  }}
                        <div class="dropdown">
                            @foreach($languages as $language)
                                <a href="{{ route('lang.switch.byPublic', $language->locale) }}">{{strtoupper($language->locale)}}</a>
                            @endforeach
                        </div>
                    </li>

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
