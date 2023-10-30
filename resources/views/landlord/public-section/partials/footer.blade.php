<footer class="footer-wrapper">
    <div class="container">
        @if (env('PRODUCT_MODE')==='DEMO')
            <div class="mt-5 mb-5 cta">
                <h3 class="h1 mb-5">Start your software subscription business</h3>
                <a class="button lg style2" href="https://codecanyon.net/user/lioncoders/portfolio">Get PeoplePro SAAS</a>
            </div>
            <hr>
        @endif
        <div class="d-flex justify-content-between mt-5">
            <div class="footer-links">
                @foreach($pages as $page)
                    <a href="{{url('pages/'.$page->slug)}}">{{$page->title}}</a>
                @endforeach
            </div>
            <div class="footer-bottom">
                <p class="copyright">&copy; {{$generalSetting->site_title}} {{date('Y')}}. All rights reserved</p>
            </div>
        </div>
    </div>
</footer>
