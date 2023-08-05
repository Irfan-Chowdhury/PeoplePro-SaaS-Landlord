<?php

namespace App\Providers;

use App\Contracts\BaseContract;
use App\Contracts\FeatureContract;
use App\Contracts\LanguageContract;
use App\Repositories\BaseRepository;
use App\Repositories\FeatureRepository;
use App\Repositories\LanguageRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BaseContract::class, BaseRepository::class);
        $this->app->bind(LanguageContract::class, LanguageRepository::class);
        $this->app->bind(FeatureContract::class, FeatureRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
