<?php

namespace App\Providers;

use App\Services\CalendarApiService;
use App\Interfaces\CalendarApiInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
