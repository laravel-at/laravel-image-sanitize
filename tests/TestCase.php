<?php

namespace LaravelAt\ImageSanitize\Tests;

use LaravelAt\ImageSanitize\Facades\ImageSanitizeFacade;
use LaravelAt\ImageSanitize\ServiceProviders\ImageSanitizeServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [ImageSanitizeServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'ImageSanitize' => ImageSanitizeFacade::class,
        ];
    }
}
