<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // protected $namespace = 'App\Http\Controllers';
    // protected $namespace = 'App\Http\Controllers'; // Hide for laravel-7

    public const HOME = 'profile';

    // public function boot()
    // {
    //     parent::boot();
    // }
    // public function map()
    // {
    //     $this->mapApiRoutes();
    //     $this->mapWebRoutes();
    // }

    // protected function mapWebRoutes()
    // {
    //     Route::middleware('web')
    //          ->namespace($this->namespace)
    //          ->group(base_path('routes/web.php'));

    //     Route::middleware('web')
    //          ->namespace($this->namespace)
    //          ->group(base_path('routes/general.php'));
    // }

    // protected function mapApiRoutes()
    // {
    //     Route::prefix('api')
    //          ->middleware('api')
    //          ->namespace($this->namespace)
    //          ->group(base_path('routes/api.php'));
    // }



    // ================== SAAS =============


    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('api')
                ->domain($domain)
                ->middleware('api')
                // ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains', []);
    }

    protected function mapWebRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                // ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->domain($domain)
                // ->namespace($this->namespace)
                ->group(base_path('routes/general.php'));
        }
    }

    public function boot()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }




    // public function handle($request, Closure $next)
    // {
    //     // Check the request domain and set the route file accordingly
    //     if ($request->getHost() === config('tenancy.central_domains')) {
    //         $routeFile = 'web.php';
    //     } else {
    //         $routeFile = 'tenant.php';
    //     }
    //     // Load the specified route file
    //     app('router')->setRoutes(require base_path('routes/' . $routeFile));
    //     return $next($request);
    // }
}
