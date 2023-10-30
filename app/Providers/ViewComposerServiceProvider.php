<?php

namespace App\Providers;

use App\Models\GeneralSetting as TenantGeneralSetting;
use App\Models\Landlord\GeneralSetting as LandlordGeneralSetting;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    // public function boot(): void
    public function boot(): void
    {
        if (Schema::hasTable('general_settings') && in_array(request()->getHost(), config('tenancy.central_domains'))) {
            $generalSetting = LandlordGeneralSetting::latest()->first();
            view()->composer([
                'landlord.public-section.layouts.master',
                'landlord.public-section.pages.landing-page.index',
                'landlord.public-section.pages.renew.contact_for_renewal',
                'landlord.super-admin.pages.dashboard.index',
                'landlord.super-admin.partials.header',
                'landlord.super-admin.auth.login',
                'documentation-landlord.index',
            ], function ($view) use ($generalSetting) {
                $view->with('generalSetting', $generalSetting);
            });
        }
        // else {
        else if(Schema::hasTable('general_settings')) {

            $general_settings = TenantGeneralSetting::latest()->first();

            view()->composer([
                'layout.main',
            ], function ($view) use ($general_settings) {
                $view->with('general_settings', $general_settings);
            });
        }
    }
}



