<?php

namespace LaravelAt\ImageSanitize\Tests;


use Intervention\Image\Image;
use LaravelAt\ImageSanitize\ImageSanitize;
use LaravelAt\ImageSanitize\ImageSanitizeServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [ImageSanitizeServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'ImageSanitize' => ImageSanitize::class,
            'Image' => Image::class,
        ];
    }
}
