<?php

namespace LaravelAt\ImageSanitize;

use Closure;

class ImageSanitizeMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app(RequestHandler::class)->handle($request);
        return $next($request);
    }
}
