<?php

namespace App\Providers;

use App\Services\LocationService;
use App\Services\StationService;
use Illuminate\Support\ServiceProvider;

class StationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('App\Services\StationServiceInterface', function () {
            $locationService = new LocationService();

            return new StationService($locationService);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
