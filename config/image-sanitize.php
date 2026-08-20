<?php

use Intervention\Image\Drivers\Gd\Driver;

return [
    'allowed_mime_types' => [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/bmp',
        'image/webp',
    ],

    'patterns' => [
        '<?php',
        '<?=',
        'phar',
    ],

    'driver' => Driver::class,

    'quality' => 100,

    'auto_orientation' => true,

    'decode_animation' => true,

    'strip_metadata' => true,
];
