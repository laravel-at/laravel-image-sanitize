<?php

namespace LaravelAt\ImageSanitize\Lists;

class MimeTypeList
{
    public function get(): array
    {
        return [
            'image/jpeg',
            'image/gif',
            'image/png',
            'image/bmp',
        ];
    }
}
