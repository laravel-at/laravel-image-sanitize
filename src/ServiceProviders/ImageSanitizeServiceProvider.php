<?php

namespace LaravelAt\ImageSanitize\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use LaravelAt\ImageSanitize\ImageSanitize;
use LaravelAt\ImageSanitize\RequestHandler;

class ImageSanitizeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(ImageSanitize::class);
        $this->app->singleton(RequestHandler::class);
    }
}
