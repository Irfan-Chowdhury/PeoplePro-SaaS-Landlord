<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = 'profile';

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
