<?php

namespace LaravelAt\ImageSanitize\Lists;

use Illuminate\Contracts\Config\Repository;

class PatternList
{
    /** @var array<int, string> */
    protected const DEFAULT_PATTERNS = [
        '<?php',
        '<?=',
        'phar',
    ];

    public function __construct(
        protected ?Repository $config = null,
    ) {}

    /**
     * @return array<int, string>
     */
    public function get(): array
    {
        $patterns = $this->config?->get('image-sanitize.patterns', self::DEFAULT_PATTERNS);

        if (! is_array($patterns)) {
            return self::DEFAULT_PATTERNS;
        }

        return array_values(array_filter($patterns, is_string(...)));
    }
}
