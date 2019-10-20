<?php

namespace LaravelAt\ImageSanitize\Tests;

use LaravelAt\ImageSanitize\Facades\ImageSanitizeFacade;
use LaravelAt\ImageSanitize\ServiceProviders\ImageSanitizeServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [ImageSanitizeServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'ImageSanitize' => ImageSanitizeFacade::class,
        ];
    }
}
