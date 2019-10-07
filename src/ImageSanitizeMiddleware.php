<?php

namespace LaravelAt\ImageSanitize;

use Closure;

class ImageSanitizeMiddleware
{
    /**
     * @var \LaravelAt\ImageSanitize\RequestHandler
     */
    protected $requestHandler;

    public function __construct(RequestHandler $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->requestHandler->handle($request);

        return $next($request);
    }
}
