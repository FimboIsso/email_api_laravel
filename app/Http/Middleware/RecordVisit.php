<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SiteVisit;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RecordVisit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Enregistrer la visite seulement pour les pages GET et les réponses réussies
        if ($request->isMethod('GET') && $response->getStatusCode() == 200) {
            try {
                SiteVisit::recordVisit($request);
            } catch (\Exception $e) {
                // En cas d'erreur, on continue sans interrompre la requête
                Log::error('Erreur lors de l\'enregistrement de la visite: ' . $e->getMessage());
            }
        }

        return $response;
    }
}
