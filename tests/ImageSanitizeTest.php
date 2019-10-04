<?php

namespace LaravelAt\ImageSanitize\Tests;

use LaravelAt\ImageSanitize\ImageSanitize;
use LaravelAt\ImageSanitize\Facades\ImageSanitizeFacade;

class ImageSanitizeTest extends TestCase
{
    /** @test */
    public function it_detects_embedded_malicious_code()
    {
        $content = file_get_contents(__DIR__.'/stubs/exploit.jpeg');

        $this->assertTrue(
            app(ImageSanitize::class)->detect($content)
        );

        $this->assertTrue(ImageSanitizeFacade::detect($content));
    }

    /** @test */
    public function it_removes_malicious_code()
    {
        $content = file_get_contents(__DIR__.'/stubs/exploit.jpeg');

        $secureImage = app(ImageSanitize::class)->sanitize($content);

        $this->assertFalse(app(ImageSanitize::class)->detect($secureImage));

        $this->assertFalse(ImageSanitizeFacade::detect($secureImage));
    }
}
