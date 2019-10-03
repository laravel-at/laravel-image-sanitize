<p align="center">
    <img width="500" height="150" alt="Laravel Image Sanitize logo" src="https://raw.githubusercontent.com/laravel-at/laravel-image-sanitize/master/art/logo.png" />
</p>

# It prevents malicious code execution!

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-at/laravel-image-sanitize.svg?style=flat-square)](https://packagist.org/packages/laravel-at/laravel-image-sanitize)
[![Build Status](https://img.shields.io/travis/laravel-at/laravel-image-sanitize/master.svg?style=flat-square)](https://travis-ci.org/laravel-at/laravel-image-sanitize)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-at/laravel-image-sanitize.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-at/laravel-image-sanitize)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-at/laravel-image-sanitize.svg?style=flat-square)](https://packagist.org/packages/laravel-at/laravel-image-sanitize)

This is a small but handy package to prevent malicious code execution coming into your application through uploaded images.
It was created after being inspired by [@appelsiini](https://github.com/appelsiini)'s [talk on How to Hack your Laravel Application](https://speakerdeck.com/anamus/how-your-laravel-application-can-get-hacked-f7acca32-3721-4c06-9a2e-5965cd9a4a29)

## Installation

You can install the package via composer:

```bash
composer require laravel-at/laravel-image-sanitize
```

## Usage

Register the `ImageSanitizeMiddleware` in your `App\Http\Kernel` class
``` php
protected $routeMiddleware = [
    // ...
    'image-sanitize' => ImageSanitizeMiddleware::class,
];

```

Then, just use it in your Controller's constructor
``` php
public function __construct()
{
    $this->middleware('image-sanitize');
}
```

Or use it in your `routes/web.php` file
``` php
Route::post('/files', 'FileController@upload')
    ->name('file.upload')
    ->middleware(['image-sanitize']);
```

If you want to learn more about `middlewares`, please check out the [official Laravel documentation](https://laravel.com/docs/master/middleware)

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email adrian@nuernberger.me instead of using the issue tracker.

## Credits

- [Adrian Nürnberger](https://github.com/nuernbergerA)
- [Mathias Onea](https://github.com/mathiasonea)
- Logo by [Caneco](https://github.com/caneco)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
