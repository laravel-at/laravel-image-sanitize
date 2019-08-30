<?php

namespace LaravelAt\ImageSanitize\Tests;

use PHPUnit\Framework\TestCase;
use LaravelAt\ImageSanitize\ImageSanitizeClass;

class ImageSanitizeTest extends TestCase
{
    /** @test */
    public function it_detects_embedded_malicious_code()
    {
        $content = file_get_contents(__DIR__.'/stubs/exploit.jpeg');

        $this->assertTrue((new ImageSanitizeClass)->detect($content));
    }

    /** @test */
    public function it_removes_malicious_code()
    {
        $content = file_get_contents(__DIR__.'/stubs/exploit.jpeg');

        $secureImage = (new ImageSanitizeClass)->sanitize($content);

        $this->assertFalse((new ImageSanitizeClass)->detect($secureImage));
    }
}
