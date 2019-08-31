<?php


namespace LaravelAt\ImageSanitize\Tests;


use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\UploadedFile;
use LaravelAt\ImageSanitize\ImageSanitize;
use LaravelAt\ImageSanitize\RequestHandler;
use LaravelAt\ImageSanitize\Lists\PatternList;
use LaravelAt\ImageSanitize\Lists\MimeTypeList;

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
        $this->handler = new RequestHandler(
            new MimeTypeList
        );

        $this->sanitizer = new ImageSanitize(
            new PatternList
        );
    }

    /** @test */
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

    /** @test */
    public function it_swaps_the_file_content_with_the_sanitized_string(): void
    {
        $uploadedFile = UploadedFile::fake()->image('malicious.jpeg','100','100');
        file_put_contents($uploadedFile->getPathname(), file_get_contents(__DIR__ . '/stubs/exploit.jpeg'));

        $request = new Request;
        $request->files->set('image', $uploadedFile);

        $maliciousImageContent = $request->file('image')->get();
        $requestHandler = New RequestHandler(new MimeTypeList());
        $requestHandler->handle($request);

        $sanitizedImageContent = $request->file('image')->get();
        $this->assertNotEquals(
            $maliciousImageContent,
            $sanitizedImageContent
        );
        $this->assertFalse($this->sanitizer->detect($sanitizedImageContent));
    }
}
