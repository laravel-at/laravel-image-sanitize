# Prevent malicious code execution

A small but handy package to prevent malicious code execution coming into your application through uploaded image files.

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
Route::post('/files', 'FileController@upload')`
    ->name('file.upload')
    ->middleware(['image-sanitize']);
```

If you want to know more about how `middlewares work in general, please check out the [official Laravel documentation](https://www.laravel.com/documentation)

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
- [Mathias Onea](https://github.com/mathias_onea)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
