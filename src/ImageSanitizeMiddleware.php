<?php

namespace LaravelAt\ImageSanitize;

use Closure;
use Illuminate\Http\Request;

class ImageSanitizeMiddleware
{
    public function __construct(
        protected RequestHandler $requestHandler,
    ) {
    }

    public function handle(Request $request, Closure $next)
    {
        $this->requestHandler->handle($request);

        return $next($request);
    }
}
