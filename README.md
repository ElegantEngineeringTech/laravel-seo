# An Elegant & Flexible SEO Tag Builder for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elegantly/laravel-seo.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-seo)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/elegantengineeringtech/laravel-seo/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/elegantengineeringtech/laravel-seo/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/elegantengineeringtech/laravel-seo/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/elegantengineeringtech/laravel-seo/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/elegantly/laravel-seo.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-seo)

This package offers an extremly flexible and advanced way to manage all of your seo tags. Unlike other packages that focus on the most simple and common tags, this one implement all the protocols.

With this package you will be able to implement:

-   The Standard HTML tags (title, robots, ...)
-   [The Open Graph tags](https://ogp.me/), including structured properties, arrays and Object Types.
-   [The Twitter tags](https://developer.x.com/en/docs/x-for-websites/cards/overview/abouts-cards)
-   [Structured data (JSON-LD)](https://developers.google.com/search/docs/appearance/structured-data/intro-structured-data)

## Installation

You can install the package via composer:

```bash
composer require elegantly/laravel-seo
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-seo-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-seo-views"
```

## Usage

```php
$seo = new Elegantly\Seo();
echo $seo->echoPhrase('Hello, Elegantly!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Quentin Gabriele](https://github.com/40128136+QuentinGab)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
