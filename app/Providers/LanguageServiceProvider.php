<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer(['layout.main_partials.header', 'layout.client','landlord.super-admin.partials.header', 'landlord.public-section.layouts.master'], 'App\Http\View\Composers\LayoutComposer');
    }
}
