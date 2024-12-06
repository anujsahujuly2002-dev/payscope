<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('ifsc', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[A-Za-z]{4}[0-9]{7}$/', $value);
        }, 'The IFSC code is invalid.');
    }
}
