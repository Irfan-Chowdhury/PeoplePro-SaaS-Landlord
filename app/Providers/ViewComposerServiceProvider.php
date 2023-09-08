<?php

namespace App\Providers;

use App\Models\GeneralSetting as TenantGeneralSetting;
use App\Models\Landlord\GeneralSetting;
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
            $generalSetting = GeneralSetting::latest()->first();
            view()->composer([
                'landlord.public-section.layouts.master',
                'landlord.public-section.pages.landing-page.index',
                'landlord.public-section.pages.renew.contact_for_renewal',
            ], function ($view) use ($generalSetting) {
                $view->with('generalSetting', $generalSetting);
            });
        }
        else {
            $general_settings = TenantGeneralSetting::latest()->first();

            view()->composer([
                'layout.main',
            ], function ($view) use ($general_settings) {
                $view->with('general_settings', $general_settings);
            });
        }

        // Procedure - 1
        // $general_settings = GeneralSetting::latest()->first();

        // view()->composer('layout.main_partials.header', function ($view) use ($generalSetting) {
        //     $view->with('generalSetting', $generalSetting);
        // });



        // $general_settings = GeneralSetting::latest()->first();

        // Procedure - 2
        // view()->composer([
        //     // 'layout.main',
        //     // 'layout.main_partials.header',
        //     // 'layout.main_partials.footer',
        //     // 'projects.invoices.show',
        //     // 'dashboard',
        //     // 'layout.client',
        //     // 'frontend.Layout.navigation',
        //     // 'documentation.index',
        //     // 'vendor.translation.layout'
        // ], function ($view) use ($general_settings) {
        //     $view->with('general_settings', $general_settings);
        // });
    }
}



