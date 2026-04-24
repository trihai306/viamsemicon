<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected array $supported = ['vi', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        // 1. Try locale from route parameter
        $locale = $request->route('locale');

        // 2. Fall back to session
        if (empty($locale) || ! in_array($locale, $this->supported)) {
            $locale = Session::get('locale', 'vi');
        }

        // 3. Validate and normalise
        if (! in_array($locale, $this->supported)) {
            $locale = 'vi';
        }

        App::setLocale($locale);
        Session::put('locale', $locale);
        URL::defaults(['locale' => '']);

        return $next($request);
    }
}
