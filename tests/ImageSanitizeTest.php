<?php

namespace LaravelAt\ImageSanitize\Tests;

use Intervention\Image\ImageManager;
use LaravelAt\ImageSanitize\ImageSanitize;
use LaravelAt\ImageSanitize\Lists\PatternList;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;

class ImageSanitizeTest extends TestCase
{
    #[Test]
    public function it_detects_embedded_malicious_code(): void
    {
        $content = $this->exploitImageContents();

        $this->assertTrue(
            $this->app->make(ImageSanitize::class)->detect($content)
        );
    }

    #[Test]
    public function it_detects_short_echo_tags(): void
    {
        $this->assertTrue(
            $this->app->make(ImageSanitize::class)->detect('<?= system("id"); ?>')
        );
    }

    #[Test]
    public function it_detects_patterns_case_insensitively(): void
    {
        $this->assertTrue(
            $this->app->make(ImageSanitize::class)->detect('<?PHP echo "payload";')
        );
    }

    #[Test]
    public function it_uses_configured_detection_patterns(): void
    {
        $this->app['config']->set('image-sanitize.patterns', ['custom-payload']);

        $this->assertTrue(
            $this->app->make(ImageSanitize::class)->detect('clean-prefix CUSTOM-PAYLOAD clean-suffix')
        );
    }

    #[Test]
    public function it_includes_short_echo_tags_in_the_fallback_patterns(): void
    {
        $this->assertContains('<?=', (new PatternList)->get());
    }

    #[Test]
    public function it_does_not_resolve_the_image_manager_when_detecting_patterns(): void
    {
        $this->app->bind(ImageManager::class, function (): never {
            throw new RuntimeException('The image manager should only be resolved when sanitizing.');
        });

        $this->assertTrue(
            $this->app->make(ImageSanitize::class)->detect('<?php echo "payload";')
        );
    }

    #[Test]
    public function it_merges_default_configuration(): void
    {
        $patterns = config('image-sanitize.patterns');
        $allowedMimeTypes = config('image-sanitize.allowed_mime_types');

        $this->assertIsArray($patterns);
        $this->assertIsArray($allowedMimeTypes);
        $this->assertContains('<?php', $patterns);
        $this->assertContains('<?=', $patterns);
        $this->assertContains('image/webp', $allowedMimeTypes);
    }

    #[Test]
    public function it_removes_malicious_code(): void
    {
        $content = $this->exploitImageContents();

        $secureImage = $this->app->make(ImageSanitize::class)->sanitize($content);

        $this->assertFalse($this->app->make(ImageSanitize::class)->detect($secureImage));
    }
}
