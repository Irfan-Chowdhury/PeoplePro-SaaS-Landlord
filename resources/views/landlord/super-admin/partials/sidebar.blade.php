<nav class="side-navbar">
    <span class="brand-big">
        {{-- @if($general_setting->site_logo)
        <a href=""><img src="{{url('public/landlord/images/logo', $general_setting->site_logo)}}" width="115"></a>
        @else
        <a href=""><h1 class="d-inline">{{$general_setting->site_title}}</h1></a>
        @endif --}}
    </span>
    <ul id="side-main-menu" class="side-menu list-unstyled">
        <li><a href="#"> <i class="dripicons-meter"></i><span>{{ __('file.dashboard') }}</span></a></li>
        <li><a target="_blank" href="{{ route('landingPage.index') }}"> <i class="dripicons-monitor"></i><span>Frontend</span></a></li>

        <li><a href="{{ route('customer.index') }}"><i class="dripicons-list"></i> {{trans('file.Customers')}}</a></li>

        <li><a href=""><i class="dripicons-card"></i> {{trans('file.Payments')}}</a></li>
        <li><a href="#package" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-archive"></i><span>{{trans('file.Package')}}</span><span></a>
            <ul id="package" class="collapse list-unstyled ">
                <li id="package-list-menu"><a href="{{ route('package.index') }}">{{trans('file.Package List')}}</a></li>
                <li id="package-create-menu"><a href="{{ route('package.create') }}">{{trans('file.Add Package')}}</a></li>
            </ul>
        </li>
        <li><a href="#cms" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-stack"></i><span>{{trans('file.CMS')}}</span><span></a>
            <ul id="cms" class="collapse list-unstyled ">
                <li id="cms-hero-menu"><a href="{{ route('hero.index') }}">{{trans('file.Hero Section')}}</a></li>
                <li id="cms-module-menu"><a href="{{ route('module.index') }}">{{trans('file.Module Section')}}</a></li>
                <li id="cms-feature-menu"><a href="{{ route('feature.index') }}">{{trans('file.Feature Section')}}</a></li>
                <li id="cms-faq-menu"><a href="{{ route('faq.index') }}">{{trans('file.FAQ Section')}}</a></li>
                <li id="cms-testimonial-menu"><a href="{{ route('testimonial.index') }}">{{trans('file.Testimonial Section')}}</a></li>
                <li id="cms-tenant-signup-menu"><a href="{{ route('tenantSignupDescription.index') }}">{{trans('file.Tenant Signup Description')}}</a></li>
                <li id="cms-blog-menu"><a href="{{ route('blog.index') }}">{{trans('file.Blog Section')}}</a></li>
                <li id="cms-page-menu"><a href="{{ route('page.index') }}">  {{trans('file.Page Section')}}</a></li>
                <li id="cms-social-menu"><a href="{{ route('social.index') }}">{{trans('file.Social Section')}}</a></li>
            </ul>
        </li>

        <li><a href="#localization" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-web"></i><span>{{trans('file.Localization')}}</span><span></a>
            <ul id="localization" class="collapse list-unstyled ">
                <li id="localization-language-menu"><a href="{{ route('language.index') }}">{{trans('file.Language Setting')}}</a></li>
                {{-- <li id="localization-translation-menu"><a href="{{ route('lang.translations.index', $language) }}">{{trans('file.Translation')}} </a></li>
                <li id="localization-add-translation-menu"><a href="{{ route('lang.translations.create', $language) }}">{{trans('file.Add Translation')}} </a></li> --}}
                <li id="localization-translation-menu"><a href="{{ route('lang.translations.index', config('app.locale')) }}">{{trans('file.Translation')}} </a></li>
                <li id="localization-add-translation-menu"><a href="{{ route('lang.translations.create', config('app.locale')) }}">{{trans('file.Add Translation')}} </a></li>
            </ul>
        </li>
        <li><a href="{{ route('setting.general.index') }}"><i class="dripicons-gear"></i> {{trans('file.Settings')}}</a></li>
        <li><a target="_blank" href=""> <i class="dripicons-information"></i><span>{{trans('file.Documentation')}}</span></a></li>
    </ul>
  </nav>
