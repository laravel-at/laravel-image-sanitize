<?php

namespace LaravelAt\ImageSanitize\Tests;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\UploadedFile;
use LaravelAt\ImageSanitize\ImageSanitize;

class ImageSanitizeTest extends TestCase
{
    /** @test */
    public function it_detects_embedded_malicious_code()
    {
        $content = file_get_contents(__DIR__ . '/stubs/exploit.jpeg');

        $this->assertTrue((new ImageSanitize)->detect($content));
    }

    /** @test */
    public function it_removes_malicious_code()
    {
        $content = file_get_contents(__DIR__ . '/stubs/exploit.jpeg');

        $secureImage = (new ImageSanitize)->sanitize($content);

        $this->assertFalse((new ImageSanitize)->detect($secureImage));
    }

    /** @test */
    public function it_detects_images_in_the_request(): void
    {
        $request = new Request;

        $request->files->set('image', UploadedFile::fake()->image('image.jpeg'));
        $request->files->set('pdf', UploadedFile::fake()->create('document.pdf'));

        $imageSanitizeClass = new ImageSanitizeClass();
        $this->assertArrayHasKey(
            'image',
            $imageSanitizeClass->getImages($request->allFiles())
        );
        $this->assertArrayNotHasKey(
            'pdf',
            $imageSanitizeClass->getImages($request->allFiles())
        );
    }
}
