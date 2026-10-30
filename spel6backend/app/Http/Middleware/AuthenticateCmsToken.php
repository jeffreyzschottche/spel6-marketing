<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards /api/v1/cms/* with the server-only SPEL6_CMS_TOKEN that Zschot CMS sends as a bearer token.
 */
class AuthenticateCmsToken
{
    private const MAX_FAILURES = 5;

    private const BLOCK_SECONDS = 900;

    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('spel6.cms_token');
        if (strlen($expected) < 32) {
            return response()->json(['message' => 'cms_not_configured'], 503)->header('Cache-Control', 'no-store');
        }

        $key = 'spel6-cms-token:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, self::MAX_FAILURES)) {
            return response()->json(['message' => 'Too many attempts.'], 429)
                ->header('Retry-After', (string) RateLimiter::availableIn($key))
                ->header('Cache-Control', 'no-store');
        }

        $provided = $request->bearerToken();
        if (! is_string($provided) || ! hash_equals(hash('sha256', $expected), hash('sha256', $provided))) {
            RateLimiter::hit($key, self::BLOCK_SECONDS);

            return response()->json(['message' => 'Unauthenticated.'], 401)
                ->header('WWW-Authenticate', 'Bearer')
                ->header('Cache-Control', 'no-store');
        }

        RateLimiter::clear($key);

        return $next($request)->header('Cache-Control', 'no-store');
    }
}
