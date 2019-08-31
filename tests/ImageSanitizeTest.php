<?php

namespace LaravelAt\ImageSanitize\Tests;

use LaravelAt\ImageSanitize\ImageSanitize;

class ImageSanitizeTest extends TestCase
{
    /** @test */
    public function it_detects_embedded_malicious_code()
    {
        $content = file_get_contents(__DIR__ . '/stubs/exploit.jpeg');

        $this->assertTrue(
            app(ImageSanitize::class)->detect($content)
        );
    }

    /** @test */
    public function it_removes_malicious_code()
    {
        $content = file_get_contents(__DIR__ . '/stubs/exploit.jpeg');

        $secureImage = app(ImageSanitize::class)->sanitize($content);

        $this->assertFalse(app(ImageSanitize::class)->detect($secureImage));
    }
}
