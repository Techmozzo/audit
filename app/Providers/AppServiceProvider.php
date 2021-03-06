<?php

namespace App\Providers;

use App\Services\Concretes\Registration;
use App\Services\Interfaces\RegistrationInterface;
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
        //  //check that app is local
        //  if ($this->app->isLocal()) {
        //     //if local register your services you require for development
        //     $this->app->register(Barryvdh\Debugbar\ServiceProvider::class);
        // } else {
        //     //else register your services you require for production
        //     $this->app['request']->server->set('HTTPS', true);
        // }

        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Builder::defaultStringLength(191);
        $this->app->singleton(RegistrationInterface::class, Registration::class);
    }
}
