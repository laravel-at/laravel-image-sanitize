<?php

namespace LaravelAt\ImageSanitize\Tests;

use PHPUnit\Framework\TestCase;
use LaravelAt\ImageSanitize\ImageSanitize;
use LaravelAt\ImageSanitize\Lists\PatternList;

class ImageSanitizeTest extends TestCase
{
    /** @test */
    public function it_detects_embedded_malicious_code()
    {
        $content = file_get_contents(__DIR__ . '/stubs/exploit.jpeg');

        $this->assertTrue(
            (new ImageSanitize(new PatternList()))->detect($content)
        );
    }

    /** @test */
    public function it_removes_malicious_code()
    {
        $content = file_get_contents(__DIR__ . '/stubs/exploit.jpeg');
        $imageSanitize = new ImageSanitize(
            new PatternList()
        );
        $secureImage = $imageSanitize->sanitize($content);

        $this->assertFalse($imageSanitize->detect($secureImage));
    }
}
