<?php

namespace LaravelAt\ImageSanitize;

use Closure;
use LaravelAt\ImageSanitize\Lists\MimeTypeList;

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
        (new RequestHandler(new MimeTypeList))->handle($request);
        return $next($request);
    }
}
