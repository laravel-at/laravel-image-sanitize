# Changelog

All notable changes to `laravel-image-sanitize` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project follows [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## v5.0.1 - 2026-08-21

- Detect PHP short echo tags and match forbidden payload patterns in a case-insensitive way. If you have published the configuration file prior to this version, you should add `<?=` to your `patterns` array.

## v5.0.0 - 2026-06-10

### Breaking Changes

- Changed `ImageSanitize::sanitize()` to return `Intervention\Image\Interfaces\EncodedImageInterface` instead of the concrete `Intervention\Image\EncodedImage` class.
- Upgraded the package dependency from Intervention Image 3 to Intervention Image 4.
- Added an explicit `Symfony\Component\HttpFoundation\Response` return type to `ImageSanitizeMiddleware::handle()`.
- Removed the legacy Scrutinizer integration in favor of GitHub Actions, Pint, and PHPStan.
- Added Pint and PHPStan level 7 to the default quality workflow, making contributor checks stricter.

### Added

- Added a publishable `image-sanitize` configuration file.
- Added configuration for allowed MIME types, detection patterns, Intervention Image driver, output quality, EXIF auto-orientation, animation decoding, and metadata stripping.
- Added WebP to the default list of image MIME types.
- Added tests for package configuration, WebP uploads, mixed flat/nested uploads, and repeated nested upload field names.
- Added Laravel Pint and PHPStan as development quality tools.
- Added Composer scripts for formatting, static analysis, and full local quality checks.

### Changed

- Resolve `Intervention\Image\ImageManager` through Laravel's container and respect an existing application binding.
- Use Intervention Image 4's binary decode API when sanitizing uploaded image contents.
- Use Laravel/Symfony uploaded file MIME detection instead of calling `mime_content_type()` directly.
- Update README usage examples for modern Laravel middleware registration in `bootstrap/app.php`.
- Update the GitHub Actions checkout action to `actions/checkout@v4`.
- Update GitHub Actions to run Pint and PHPStan before the test suite.
- Raise PHPStan analysis to level 7.
- Update the test script to run without requiring a local coverage driver.
- Remove the legacy Scrutinizer configuration and README badge.

### Fixed

- Preserve all nested uploaded files when flat and nested file inputs are mixed in the same request.
- Preserve nested uploads that reuse field names inside repeated array inputs.
- Declare the `illuminate/http` dependency explicitly.
- Avoid resolving `Intervention\Image\ImageManager` when only detecting payload patterns.

## v4.0.0 - 2026-04-27

### Changed

- Added Laravel 13 support.
- Increased the minimum supported PHP version to 8.3.

## v3.0.0 - 2025-03-03

### Changed

- Migrated to Intervention Image 3.
- Added Laravel 12 support.
- Dropped support for older framework versions.

## v2.2.0 - 2024-04-10

### Added

- Added Laravel 11 compatibility.

## v2.1.0 - 2023-04-07

### Added

- Added Laravel 10 support.

### Changed

- Updated supported framework constraints to focus on current Laravel versions.

## v2.0.1 - 2022-02-10

### Fixed

- Removed the stale PHP 7.2 requirement from `composer.json`.

## v2.0.0 - 2022-02-10

### Added

- Added Laravel 9 support.

### Changed

- Dropped support for end-of-life Laravel and PHP versions.
- Cleaned up the GitHub Actions workflow.
- Applied code style cleanup.

## v1.5.0 - 2021-01-27

### Added

- Added PHP 8 support.
- Added PHP 8 test coverage.

### Changed

- Excluded Laravel 5.8 from the PHP 8 test matrix.

## v1.4.0 - 2020-09-16

### Added

- Added Laravel 8 support.

### Changed

- Updated GitHub Actions and StyleCI configuration.
- Cleaned up version constraints.

## v1.3.1 - 2020-06-12

### Changed

- Updated the README middleware example to use the middleware fully qualified class name.

## v1.3.0 - 2020-06-05

### Fixed

- Normalized uploaded files so multiple file uploads can be handled correctly.

## v1.2.1 - 2020-04-18

### Fixed

- Fixed Scrutinizer configuration.
- Renamed the test workflow.

## v1.2.0 - 2020-04-18

### Added

- Added Laravel 7 support.

### Changed

- Dropped support for older Laravel versions.
- Replaced Travis CI with GitHub Actions.

## v1.1.1 - 2019-10-21

### Added

- Added facade test coverage.

### Fixed

- Applied StyleCI fixes.

## v1.1.0 - 2019-10-15

### Added

- Added a project logo.
- Added PHP 7.2 to the Travis CI test matrix.
- Added Composer caching to Travis CI.

### Fixed

- Added the missing `parent::setUp()` call in the test case.

### Changed

- Updated and cleaned up README content.

## v1.0.0 - 2019-09-04

### Added

- Initial release of the Laravel image sanitization middleware.
- Added detection of forbidden payload patterns in uploaded image content.
- Added MIME-type based filtering for uploaded image files.
- Added sanitization by re-encoding detected images while preserving output quality.
- Added request handling tests and core sanitizer tests.
- Added package auto-discovery support for the service provider and facade.
- Added README usage documentation and project metadata.
