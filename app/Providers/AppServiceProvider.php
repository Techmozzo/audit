<?php

namespace App\Providers;

use App\Services\Registration;
use App\Interfaces\RegistrationInterface;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\URL;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Builder::defaultStringLength(191);
        $this->app->singleton(RegistrationInterface::class, Registration::class);
    }
}
