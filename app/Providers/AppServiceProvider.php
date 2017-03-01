<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layout.base', function($view) {
            $view->with('settings', Setting::first());
        });
        view()->composer('layout.sidebar', function($view) {
            $view->with('settings', Setting::first());
        });
        view()->composer('cotizaciones.form', function($view) {
            $view->with('settings', Setting::first());
        });
        view()->composer('cotizaciones.pdf', function($view) {
            $view->with('settings', Setting::first());
        });
        view()->composer('emails.estimate', function($view) {
            $view->with('settings', Setting::first());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
