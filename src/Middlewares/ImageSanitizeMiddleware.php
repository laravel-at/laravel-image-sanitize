<?php

namespace LaravelAt\ImageSanitize\Middlewares;

use Closure;
use LaravelAt\ImageSanitize\ImageSanitizeClass;

class ImageSanitizeMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request = ImageSanitizeClass::handle($request);

        return $next($request);
    }
}
