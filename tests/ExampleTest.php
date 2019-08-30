<?php

namespace LaravelAt\ImageSanitize\Tests;

use PHPUnit\Framework\TestCase;
use LaravelAt\ImageSanitize\ImageSanitizeClass;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_detects_embedded_malicious_code()
    {
        $content = file_get_contents('../stubs/exploit.jpeg');

        $this->assertTrue((new ImageSanitizeClass)->detect($content));
    }
}
