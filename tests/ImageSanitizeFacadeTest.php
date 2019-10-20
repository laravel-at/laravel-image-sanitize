<?php

namespace LaravelAt\ImageSanitize\Tests;

use ImageSanitize;

class ImageSanitizeFacadeTest extends TestCase
{
	/** @test */
	public function it_provides_a_facade()
	{
        $content = file_get_contents(__DIR__.'/stubs/exploit.jpeg');

        $this->assertTrue(ImageSanitize::detect($content));
	}
}
