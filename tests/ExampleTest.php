<?php

namespace LaravelAt\ImageSanitize\Tests;

use Illuminate\Http\Request;
use LaravelAt\ImageSanitize\ImageSanitizeClass;
use LaravelAt\ImageSanitize\Middlewares\ImageSanitizeMiddleware;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_detects_embedded_malicious_code()
    {
        $content = file_get_contents('../stubs/exploit.jpeg');

        $this->assertTrue((new ImageSanitizeClass)->detect($content));
    }

    /** @test */
    public function true_is_true()
    {
        $request = new Request;

        $request->merge([
            'title' => 'Title is in mixed CASE',
        ]);

        $middleware = new ImageSanitizeMiddleware;

        $middleware->handle($request, function ($req) {
            //$this->assertEquals('Title is in Mixed Case', $req->title);
        });
    }
}
