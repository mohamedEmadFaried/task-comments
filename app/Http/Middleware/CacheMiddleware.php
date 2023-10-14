<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Cache;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $key, $minutes = 10)
    {
        $cacheKey = 'route:' . $request->fullUrl();
        // dd(Cache::get($cacheKey));

        // if (Cache::has($cacheKey)) {
        //     return Cache::get($cacheKey);
        // }
        // Execute the middleware stack to get the response
        $response = $next($request);
    
        // Get the content of the response (the data to cache)
        $content = $response->getContent();
    
        // Store the content in the cache
        Cache::put($cacheKey, $content, now()->addMinutes($minutes));
    
        // Create a new response using the cached content
        $cachedResponse = new Response($content);
    
        return $cachedResponse;
    }
    
}
