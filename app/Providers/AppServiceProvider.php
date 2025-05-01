<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
    public function boot()
    {
        // Get the browser's preferred language
        $locale = substr(request()->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
    
        // Set locale dynamically based on browser language (en or fr)
        if (in_array($locale, ['en', 'fr'])) {
            app()->setLocale($locale);
        } else {
            app()->setLocale('en');  // Default to English if browser language is neither 'en' nor 'fr'
        }
    }
    
}
