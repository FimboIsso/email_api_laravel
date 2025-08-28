<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class OtpRateLimiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $maxAttempts = 5, int $decayMinutes = 60): Response
    {
        $key = $this->resolveRequestSignature($request);
        $maxAttempts = (int) $maxAttempts;
        $decayMinutes = (int) $decayMinutes;

        if ($this->tooManyAttempts($key, $maxAttempts)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Trop de tentatives. Veuillez réessayer plus tard.',
                'retry_after' => $this->getTimeUntilNextRetry($key)
            ], 429);
        }

        $this->incrementAttempts($key, $decayMinutes);

        return $next($request);
    }

    /**
     * Resolve request signature for rate limiting.
     */
    protected function resolveRequestSignature(Request $request): string
    {
        $email = $request->input('email', '');
        $ip = $request->ip();
        $route = $request->route() ? $request->route()->getName() : 'unknown';

        return 'otp_rate_limit:' . md5($email . '|' . $ip . '|' . $route);
    }

    /**
     * Determine if the given key has been "accessed" too many times.
     */
    protected function tooManyAttempts(string $key, int $maxAttempts): bool
    {
        return Cache::get($key, 0) >= $maxAttempts;
    }

    /**
     * Increment the counter for a given key for a given decay time.
     */
    protected function incrementAttempts(string $key, int $decayMinutes): int
    {
        $count = Cache::get($key, 0) + 1;
        Cache::put($key, $count, now()->addMinutes($decayMinutes));

        return $count;
    }

    /**
     * Get the number of seconds until the next retry.
     */
    protected function getTimeUntilNextRetry(string $key): int
    {
        $cacheKey = $key . ':timer';
        $resetTime = Cache::get($cacheKey);

        if (!$resetTime) {
            $resetTime = now()->addHour()->timestamp;
            Cache::put($cacheKey, $resetTime, now()->addHour());
        }

        return max(0, $resetTime - now()->timestamp);
    }
}
