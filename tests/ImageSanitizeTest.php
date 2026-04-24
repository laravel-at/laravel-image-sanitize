<?php

namespace LaravelAt\ImageSanitize\Tests;

use LaravelAt\ImageSanitize\ImageSanitize;
use PHPUnit\Framework\Attributes\Test;

class ImageSanitizeTest extends TestCase
{
    #[Test]
    public function it_detects_embedded_malicious_code()
    {
        $content = file_get_contents(__DIR__.'/stubs/exploit.jpeg');

        $this->assertTrue(
            $this->app->make(ImageSanitize::class)->detect($content)
        );
    }

    #[Test]
    public function it_removes_malicious_code()
    {
        $content = file_get_contents(__DIR__.'/stubs/exploit.jpeg');

        $secureImage = $this->app->make(ImageSanitize::class)->sanitize($content);

        $this->assertFalse($this->app->make(ImageSanitize::class)->detect($secureImage));
    }
}
