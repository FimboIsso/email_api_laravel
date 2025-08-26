<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['en', 'fr'];

        // Vérifier si une langue est spécifiée dans l'URL
        if ($request->has('lang') && in_array($request->get('lang'), $supportedLocales)) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
        } else {
            // Utiliser la langue stockée en session ou celle par défaut
            $locale = Session::get('locale', config('app.locale'));
        }

        // S'assurer que la langue est supportée
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
