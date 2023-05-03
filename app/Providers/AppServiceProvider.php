<?php

namespace App\Providers;

use App\Interfaces\PersonApiInterface;
use App\Services\CalendarApiService;
use App\Interfaces\CalendarApiInterface;
use App\Services\PersonApiService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CalendarApiInterface::class, function (Application $app) {
            return new CalendarApiService(config('services.calendar_api.url'));
        });

        $this->app->singleton(PersonApiInterface::class, function (Application $app) {
            return new PersonApiService(
                config('services.person_api.url'),
                config('services.person_api.token'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
