<?php

namespace App\Providers;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Response;
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

        Response::macro('success', function ($status, $message, $data = null){
            $result = ['success' =>  true, 'message' => $message];
            if($data !== null) $result['data'] = $data;
            return \response()->json($result, $status);
        });

        Response::macro('error', function ($status, $message, $errors){
            return \response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $errors
            ], $status);
        });
    }
}
