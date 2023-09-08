<?php

namespace App\Providers;

use App\Contracts\AnalyticSettingContract;
use App\Contracts\BaseContract;
use App\Contracts\BlogContract;
use App\Contracts\FaqContract;
use App\Contracts\FaqDetailContract;
use App\Contracts\FeatureContract;
use App\Contracts\GeneralSettingContract;
use App\Contracts\LanguageContract;
use App\Contracts\MailSettingContract;
use App\Contracts\ModuleContract;
use App\Contracts\ModuleDetailContract;
use App\Contracts\PackageContract;
use App\Contracts\PageContract;
use App\Contracts\PaymentSettingContract;
use App\Contracts\PermissionContract;
use App\Contracts\SeoSettingContract;
use App\Contracts\SocialContract;
use App\Contracts\TenantContract;
use App\Contracts\TenantSignupDescriptionContract;
use App\Contracts\TestimonialContract;
use App\Repositories\AnalyticSettingRepository;
use App\Repositories\BaseRepository;
use App\Repositories\BlogRepository;
use App\Repositories\FaqDetailRepository;
use App\Repositories\FaqRepository;
use App\Repositories\FeatureRepository;
use App\Repositories\GeneralSettingRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\MailSettingRepository;
use App\Repositories\ModuleDetailRepository;
use App\Repositories\ModuleRepository;
use App\Repositories\PackageRepository;
use App\Repositories\PageRepository;
use App\Repositories\PaymentSettingRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\SeoSettingRepository;
use App\Repositories\SocialRepository;
use App\Repositories\TenantRepository;
use App\Repositories\TenantSignupDescriptionRepository;
use App\Repositories\TestimonialRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BaseContract::class, BaseRepository::class);
        $this->app->bind(LanguageContract::class, LanguageRepository::class);
        $this->app->bind(SocialContract::class, SocialRepository::class);
        $this->app->bind(FeatureContract::class, FeatureRepository::class);
        $this->app->bind(GeneralSettingContract::class, GeneralSettingRepository::class);
        $this->app->bind(ModuleContract::class, ModuleRepository::class);
        $this->app->bind(ModuleDetailContract::class, ModuleDetailRepository::class);
        $this->app->bind(FaqContract::class, FaqRepository::class);
        $this->app->bind(FaqDetailContract::class, FaqDetailRepository::class);
        $this->app->bind(TestimonialContract::class, TestimonialRepository::class);
        $this->app->bind(TenantSignupDescriptionContract::class, TenantSignupDescriptionRepository::class);
        $this->app->bind(BlogContract::class, BlogRepository::class);
        $this->app->bind(PageContract::class, PageRepository::class);
        $this->app->bind(AnalyticSettingContract::class, AnalyticSettingRepository::class);
        $this->app->bind(SeoSettingContract::class, SeoSettingRepository::class);
        $this->app->bind(PaymentSettingContract::class, PaymentSettingRepository::class);
        $this->app->bind(MailSettingContract::class, MailSettingRepository::class);
        $this->app->bind(PackageContract::class, PackageRepository::class);
        $this->app->bind(PermissionContract::class, PermissionRepository::class);
        $this->app->bind(TenantContract::class, TenantRepository::class);
    }


    public function boot(): void
    {

    }
}
