<?php

namespace LaravelAt\ImageSanitize\Middlewares;

use Closure;

class ImageSanitizeMiddleware
{
    public function handle($request, Closure $next)
    {

        return $next($request);
    }
}
