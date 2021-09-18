<?php

namespace App\Providers;

use App\Services\Concretes\Registration;
use App\Services\Interfaces\RegistrationInterface;
use Illuminate\Database\Schema\Builder;
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
        Builder::defaultStringLength(191);
        $this->app->singleton(RegistrationInterface::class, Registration::class);
    }
}
