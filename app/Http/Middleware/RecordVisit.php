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
     * Routes to exclude from visit tracking
     */
    private $excludedPaths = [
        'api/*',
        'admin/*',
        '_debugbar/*',
        'telescope/*',
        'horizon/*',
        'favicon.ico',
        'robots.txt',
        'sitemap.xml',
    ];

    /**
     * File extensions to exclude
     */
    private $excludedExtensions = [
        'css',
        'js',
        'png',
        'jpg',
        'jpeg',
        'gif',
        'svg',
        'ico',
        'woff',
        'woff2',
        'ttf',
        'eot',
        'pdf',
        'zip',
        'rar',
        'txt',
        'json',
        'xml'
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only record visits for successful GET requests
        if (!$this->shouldRecordVisit($request, $response)) {
            return $response;
        }

        try {
            // Record visit asynchronously to avoid impacting response time
            dispatch(function () use ($request) {
                SiteVisit::recordVisit($request);
            })->afterResponse();
        } catch (\Exception $e) {
            // En cas d'erreur, on continue sans interrompre la requête
            Log::error('Erreur lors de l\'enregistrement de la visite: ' . $e->getMessage(), [
                'url' => $request->url(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }

        return $response;
    }

    /**
     * Determine if visit should be recorded
     */
    private function shouldRecordVisit(Request $request, Response $response): bool
    {
        // Only GET requests
        if (!$request->isMethod('GET')) {
            return false;
        }

        // Only successful responses
        if ($response->getStatusCode() !== 200) {
            return false;
        }

        // Check excluded paths
        $path = $request->path();
        foreach ($this->excludedPaths as $excludedPath) {
            if (fnmatch($excludedPath, $path)) {
                return false;
            }
        }

        // Check file extensions
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (in_array($extension, $this->excludedExtensions)) {
            return false;
        }

        // Exclude AJAX requests (optional)
        if ($request->ajax()) {
            return false;
        }

        return true;
    }
}
