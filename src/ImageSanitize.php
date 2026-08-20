<?php

namespace LaravelAt\ImageSanitize;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\EncodedImageInterface;
use LaravelAt\ImageSanitize\Lists\PatternList;

class ImageSanitize
{
    protected ImageManager $imageManager;

    public function __construct(
        protected PatternList $patternList,
        protected ?Repository $config = null,
        protected ?Container $container = null,
    ) {}

    public function detect(string $content): bool
    {
        foreach ($this->patternList->get() as $forbiddenPattern) {
            if (stripos($content, $forbiddenPattern) !== false) {
                return true;
            }
        }

        return false;
    }

    public function sanitize(string $content): EncodedImageInterface
    {
        $image = $this->imageManager()->decodeBinary($content);

        return $image->encode(new AutoEncoder(
            quality: (int) ($this->config?->get('image-sanitize.quality', 100) ?? 100)
        ));
    }

    protected function imageManager(): ImageManager
    {
        if (isset($this->imageManager)) {
            return $this->imageManager;
        }

        if ($this->container?->bound(ImageManager::class) === true) {
            $this->imageManager = $this->container->get(ImageManager::class);

            return $this->imageManager;
        }

        $this->imageManager = new ImageManager(
            Driver::class,
            strip: true,
        );

        return $this->imageManager;
    }
}
