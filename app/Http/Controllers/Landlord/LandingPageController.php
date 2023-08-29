<?php

namespace App\Http\Controllers\Landlord;

use App\Contracts\BlogContract;
use App\Contracts\FaqContract;
use App\Contracts\FeatureContract;
use App\Contracts\ModuleContract;
use App\Contracts\PackageContract;
use App\Contracts\PageContract;
use App\Contracts\SocialContract;
use App\Contracts\TenantSignupDescriptionContract;
use App\Contracts\TestimonialContract;
use App\Http\Controllers\Controller;
use App\Http\traits\PermissionHandleTrait;
use App\Models\Landlord\Hero;
use App\Models\Landlord\Page;
use App\Models\Landlord\Social;
use App\Models\Tenant;
use App\Services\SocialService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LandingPageController extends Controller
{

    public $languageId;
    use PermissionHandleTrait;

    public function __construct(
        public SocialContract $socialContract,
        public BlogContract $blogContract,
        public PageContract $pageContract
    )
    {
        $this->middleware(function ($request, $next){
            // $this->languageId = Session::has('TempSuperAdminLangId')==true ? Session::get('TempSuperAdminLangId') : Session::get('DefaultSuperAdminLangId');
            $this->languageId = Session::has('TempPublicLangId')==true ? Session::get('TempPublicLangId') : Session::get('DefaultSuperAdminLangId');
            return $next($request);
        });
    }

    private function test()
    {
        $tenant = Tenant::create(['id' => 'bar']);
        $tenant->domains()->create(['domain' => 'bar'.'.'.env('CENTRAL_DOMAIN')]); // This Line
    }


    public function index(
        ModuleContract $moduleContract,
        FeatureContract $featureContract,
        FaqContract $faqContract,
        TestimonialContract $testimonialContract,
        TenantSignupDescriptionContract $tenantSignupDescriptionContract,
        PackageContract $packageContract,
    )
    {
        $socials = $this->socialContract->getOrderByPosition(); //Common
        $hero = Hero::where('language_id',1)->latest()->first();
        $module  = $moduleContract->fetchLatestDataByLanguageIdWithRelation(['moduleDetails'], $this->languageId);

        // ========= Test ================

        // return $this->languageId;
        // return Session::get('DefaultSuperAdminLangId');
        // $languageId = Session::has('TempSuperAdminLangId')==true ? Session::get('TempSuperAdminLangId') : Session::get('DefaultSuperAdminLangId');
        // return $languageId;

        // return $this->test();

        // ========== Test =============

        $faq  = $faqContract->fetchLatestDataByLanguageIdWithRelation(['faqDetails'], $this->languageId);
        $features = $featureContract->all();
        $testimonials = $testimonialContract->getOrderByPosition();
        $tenantSignupDescription =  $tenantSignupDescriptionContract->fetchLatestDataByLanguageId($this->languageId);
        $blogs =  $this->blogContract->getAllByLanguageId($this->languageId);
        $pages =  $this->pageContract->getAllByLanguageId($this->languageId); //Common

        $saasFeatures =  $this->features();
        $packages = $packageContract->all();

        return view('landlord.public-section.pages.landing-page.index',compact([
            'socials','hero','module','features','faq','testimonials','tenantSignupDescription',
            'blogs','pages', 'saasFeatures','packages'
        ]));
    }

    public function blog()
    {
        $socials = $this->socialContract->getOrderByPosition(); //Common
        $blogs =  $this->blogContract->getAllByLanguageId($this->languageId);
        $pages =  $this->pageContract->getAllByLanguageId($this->languageId); //Common

        return view('landlord.public-section.pages.blogs.index',compact('socials','blogs','pages'));
    }

    public function blogDetail($slug)
    {
        $socials = $this->socialContract->getOrderByPosition(); //Common
        $blog =  $this->blogContract->fetchLatestDataBySlug($slug);
        $pages =  $this->pageContract->getAllByLanguageId($this->languageId); //Common

        return view('landlord.public-section.pages.blogs.blog-details',compact('socials', 'blog', 'pages'));
    }

    public function pageDetails($slug)
    {
        $socials = $this->socialContract->getOrderByPosition(); //Common
        $page =  $this->pageContract->fetchLatestDataBySlug($slug);
        $pages =  $this->pageContract->getAllByLanguageId($this->languageId); //Common

        return view('landlord.public-section.pages.pages.page-details',compact('socials', 'page', 'pages'));
    }
}
