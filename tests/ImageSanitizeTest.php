<?php

namespace LaravelAt\ImageSanitize\Tests;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\UploadedFile;
use LaravelAt\ImageSanitize\ImageSanitizeClass;

class ImageSanitizeTest extends TestCase
{
    /** @test */
    public function it_detects_embedded_malicious_code()
    {
        $content = file_get_contents('../stubs/exploit.jpeg');

        $this->assertTrue((new ImageSanitizeClass)->detect($content));
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
