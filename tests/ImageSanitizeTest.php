<?php

namespace LaravelAt\ImageSanitize\Tests;

use LaravelAt\ImageSanitize\ImageSanitize;

class ImageSanitizeTest extends TestCase
{
    /** @test */
    public function it_detects_embedded_malicious_code()
    {
        $content = file_get_contents(__DIR__.'/stubs/exploit.jpeg');

        $this->assertTrue((new ImageSanitize)->detect($content));
    }

    /** @test */
    public function it_removes_malicious_code()
    {
        $content = file_get_contents(__DIR__.'/stubs/exploit.jpeg');

        $secureImage = (new ImageSanitize)->sanitize($content);

        $this->assertFalse((new ImageSanitize)->detect($secureImage));
    }
}
