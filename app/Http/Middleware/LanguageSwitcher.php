<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LanguageSwitcher
{
    public function handle(Request $request, Closure $next)
    {
        // Check the language segment (like /en or /fr)
        $language = $request->segment(1);

        if (in_array($language, ['en', 'fr'])) {
            app()->setLocale($language);  // Set the app locale to the selected language
        } else {
            app()->setLocale('en');  // Default language is English
        }

        return $next($request);
    }
}
