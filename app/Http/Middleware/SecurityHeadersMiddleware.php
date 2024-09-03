<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Random\RandomException;

class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $nonce = base64_encode(random_bytes(22));
        } catch (RandomException $e) {
            dd($e->getMessage());
        }

        $request->attributes->add(['csp_nonce' => $nonce]);

        $response = $next($request);
        if (\App::isProduction())
            $response->headers->set('Content-Security-Policy', "script-src 'self' 'nonce-{$nonce}'; object-src 'none'; style-src 'self' fonts.googleapis.com fonts.bunny.net");

        return $response;
    }
}
