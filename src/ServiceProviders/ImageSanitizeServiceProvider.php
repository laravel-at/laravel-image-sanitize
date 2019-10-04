<?php

namespace LaravelAt\ImageSanitize\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use LaravelAt\ImageSanitize\ImageSanitize;
use LaravelAt\ImageSanitize\RequestHandler;
use LaravelAt\ImageSanitize\Lists\PatternList;
use LaravelAt\ImageSanitize\Lists\MimeTypeList;

class ImageSanitizeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('image-sanitize.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'image-sanitize');

        $this->app->singleton(ImageSanitize::class, function () {
            return new ImageSanitize(new PatternList);
        });

        $this->app->singleton(RequestHandler::class, function () {
            return new RequestHandler(new MimeTypeList);
        });

        $this->app->alias(ImageSanitize::class, 'image-sanitize');
    }
}
