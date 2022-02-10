<?php

namespace LaravelAt\ImageSanitize\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use LaravelAt\ImageSanitize\ImageSanitize;
use LaravelAt\ImageSanitize\RequestHandler;

class ImageSanitizeServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $this->app->singleton(ImageSanitize::class);
        $this->app->singleton(RequestHandler::class);
    }
}
