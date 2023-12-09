<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('custom_rule', function ($attribute, $value, $parameters, $validator) {
            // Use a regular expression to validate the input.
            return preg_match('/^[A-Za-z ,.\-]+$/', $value);
        });

        // Optionally, define a custom error message for the rule.
        Validator::replacer('custom_rule', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute contains invalid characters.');
        });
    }
}
