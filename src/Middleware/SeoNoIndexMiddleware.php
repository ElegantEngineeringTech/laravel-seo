<?php

namespace Elegantly\Seo\Middleware;

use Closure;
use Elegantly\Seo\Facades\SeoManager;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoNoIndexMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        SeoManager::current()->noIndex();

        return $next($request);
    }
}
