<?php

namespace App\Providers;

use App\Services\UtilityService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('utility', UtilityService::class);
        require_once(app_path().'/Helpers/helper.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		if(isset($_COOKIE['language'])) {
			App::setLocale($_COOKIE['language']);
		} else {
			// App::setLocale('English');
			App::setLocale('en');
		}
    }
}
