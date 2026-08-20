<?php

namespace LaravelAt\ImageSanitize\Tests;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use LaravelAt\ImageSanitize\ImageSanitize;
use LaravelAt\ImageSanitize\RequestHandler;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;

class RequestHandlerTest extends TestCase
{
    /**
     * @var RequestHandler
     */
    protected $handler;

    /**
     * @var ImageSanitize
     */
    protected $sanitizer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = $this->app->make(RequestHandler::class);

        $this->sanitizer = $this->app->make(ImageSanitize::class);
    }

    #[Test]
    public function it_detects_images_in_the_request(): void
    {
        $request = new Request;

        $request->files->set('image', UploadedFile::fake()->image('image.jpeg'));
        $request->files->set('pdf', UploadedFile::fake()->create('document.pdf'));

        $this->assertArrayHasKey(
            'image',
            $this->handler->getImages($request->allFiles())
        );
        $this->assertArrayNotHasKey(
            'pdf',
            $this->handler->getImages($request->allFiles())
        );
    }

    #[Test]
    public function it_detects_webp_images_in_the_request(): void
    {
        $request = new Request;

        $request->files->set('image', UploadedFile::fake()->image('image.webp'));

        $this->assertArrayHasKey(
            'image',
            $this->handler->getImages($request->allFiles())
        );
    }

    #[Test]
    public function it_detects_images_in_mixed_flat_and_nested_uploads(): void
    {
        $request = new Request;

        $request->files->set('avatar', UploadedFile::fake()->image('avatar.jpeg'));
        $request->files->set('gallery', [
            UploadedFile::fake()->image('gallery.jpeg'),
        ]);

        try {
            $images = $this->handler->getImages($request->allFiles());
        } catch (\TypeError $exception) {
            $this->fail('Mixed flat and nested uploads should be traversed recursively.');
        }

        $filenames = array_map(
            fn (UploadedFile $file): string => $file->getClientOriginalName(),
            $images
        );

        $this->assertContains('avatar.jpeg', $filenames);
        $this->assertContains('gallery.jpeg', $filenames);
    }

    #[Test]
    public function it_keeps_nested_uploads_with_repeated_field_names(): void
    {
        $request = new Request;

        $request->files->set('gallery', [
            ['image' => UploadedFile::fake()->image('first.jpeg')],
            ['image' => UploadedFile::fake()->image('second.jpeg')],
        ]);

        $images = $this->handler->getImages($request->allFiles());
        $filenames = array_map(
            fn (UploadedFile $file): string => $file->getClientOriginalName(),
            $images
        );

        $this->assertContains('first.jpeg', $filenames);
        $this->assertContains('second.jpeg', $filenames);
    }

    #[Test]
    public function it_swaps_the_file_content_with_the_sanitized_string(): void
    {
        $uploadedFile = UploadedFile::fake()->image('malicious.jpeg', 100, 100);
        file_put_contents($uploadedFile->getPathname(), $this->exploitImageContents());

        $request = new Request;
        $request->files->set('image', $uploadedFile);

        $maliciousImageContent = $uploadedFile->get();
        if ($maliciousImageContent === false) {
            $this->fail('The malicious test upload could not be read before sanitization.');
        }

        $this->handler->handle($request);

        $sanitizedImageContent = $uploadedFile->get();
        if ($sanitizedImageContent === false) {
            $this->fail('The malicious test upload could not be read after sanitization.');
        }

        $this->assertNotEquals(
            $maliciousImageContent,
            $sanitizedImageContent
        );
        $this->assertFalse($this->sanitizer->detect($sanitizedImageContent));
    }

    #[Test]
    public function it_sanitizes_images_containing_short_echo_tags(): void
    {
        $uploadedFile = UploadedFile::fake()->image('malicious.jpeg', 100, 100);
        $imageContent = $uploadedFile->get();
        if ($imageContent === false) {
            $this->fail('The test upload could not be read before adding the payload.');
        }

        $maliciousImageContent = $imageContent.'<?= system("id"); ?>';
        file_put_contents($uploadedFile->getPathname(), $maliciousImageContent);

        $this->assertTrue($this->sanitizer->detect($maliciousImageContent));

        $request = new Request;
        $request->files->set('image', $uploadedFile);

        $this->handler->handle($request);

        $sanitizedImageContent = $uploadedFile->get();
        if ($sanitizedImageContent === false) {
            $this->fail('The test upload could not be read after sanitization.');
        }

        $this->assertNotEquals($maliciousImageContent, $sanitizedImageContent);
        $this->assertFalse($this->sanitizer->detect($sanitizedImageContent));
    }

    #[Test]
    public function it_fails_closed_when_an_uploaded_image_cannot_be_read(): void
    {
        $request = new Request;

        $request->files->set('image', new class(__DIR__.'/stubs/exploit.jpeg', 'unreadable.jpeg', 'image/jpeg', null, true) extends UploadedFile
        {
            /**
             * @return false
             */
            public function get()
            {
                return false;
            }
        });

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The uploaded file could not be read.');

        $this->handler->handle($request);
    }
}
