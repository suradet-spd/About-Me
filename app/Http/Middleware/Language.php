<?php

namespace App\Http\Middleware;

use Closure;
use illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Language {
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            $locale = session()->get('locale');
            App::setLocale($locale);
        }

        return $next($request);
    }
}
?>
