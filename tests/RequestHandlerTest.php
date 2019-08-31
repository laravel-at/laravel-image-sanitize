<?php


namespace LaravelAt\ImageSanitize\Tests;


use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\UploadedFile;
use LaravelAt\ImageSanitize\RequestHandler;
use LaravelAt\ImageSanitize\Lists\MimeTypeList;

class RequestHandlerTest extends TestCase
{
    /** @test */
    public function it_detects_images_in_the_request(): void
    {
        $request = new Request;

        $request->files->set('image', UploadedFile::fake()->image('image.jpeg'));
        $request->files->set('pdf', UploadedFile::fake()->create('document.pdf'));

        $handler = new RequestHandler(
            new MimeTypeList()
        );
        $this->assertArrayHasKey(
            'image',
            $handler->getImages($request->allFiles())
        );
        $this->assertArrayNotHasKey(
            'pdf',
            $handler->getImages($request->allFiles())
        );
    }
}
