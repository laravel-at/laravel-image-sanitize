<?php

namespace LaravelAt\ImageSanitize\Tests;

use ImageSanitize;
use PHPUnit\Framework\Attributes\Test;

class ImageSanitizeFacadeTest extends TestCase
{
    #[Test]
    public function it_provides_a_facade()
    {
        $content = file_get_contents(__DIR__.'/stubs/exploit.jpeg');

        $this->assertTrue(ImageSanitize::detect($content));
    }
}
