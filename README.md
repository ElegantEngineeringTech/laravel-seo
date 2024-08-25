# An Elegant & Flexible SEO Tag Builder for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elegantly/laravel-seo.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-seo)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/elegantengineeringtech/laravel-seo/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/elegantengineeringtech/laravel-seo/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/elegantengineeringtech/laravel-seo/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/elegantengineeringtech/laravel-seo/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/elegantly/laravel-seo.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-seo)

![laravel-seo](https://repository-images.githubusercontent.com/845966143/6ff7437c-852d-41eb-8b2f-927551506a13)

This package offers an extremely flexible and advanced way to manage all of your SEO tags.

With this package, you will be able to implement:

-   The standard HTML tags (title, robots, ...)
-   [Localization](https://developers.google.com/search/docs/specialty/international/localized-versions) with alternate tags
-   [The Open Graph tags](https://ogp.me/), including structured properties, arrays, and Object Types
-   [The Twitter tags](https://developer.x.com/en/docs/x-for-websites/cards/overview/abouts-cards)
-   [Structured data (JSON-LD)](https://developers.google.com/search/docs/appearance/structured-data/intro-structured-data)

## Installation

You can install the package via Composer:

```bash
composer require elegantly/laravel-seo
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="seo-config"
```

This is the content of the published config file:

```php
return [

    'defaults' => [
        /*
        |--------------------------------------------------------------------------
        | Default Title
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <title>, "og:title", "twitter:title"
        |
        */
        'title' => env('APP_NAME', 'Laravel'),

        /*
        |--------------------------------------------------------------------------
        | Default Description
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta name="description">, <meta property="og:description">, <meta name="twitter:description">
        |
        */
        'description' => null,

        /*
        |--------------------------------------------------------------------------
        | Default Keywords
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta name="keywords">
        | Type supported: string or array of strings
        |
        */
        'keywords' => null,

        /*
        |--------------------------------------------------------------------------
        | Default Image path
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta property="og:image">, <meta name="twitter:image">
        | You can use relative path like "/opengraph.png" or url like "https://example.com/opengraph.png"
        |
        */
        'image' => null,

        /*
        |--------------------------------------------------------------------------
        | Default Robots
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta name="robots">
        | See Google documentation here: https://developers.google.com/search/docs/crawling-indexing/robots-meta-tag?hl=fr#directives
        |
        */
        'robots' => 'max-snippet:-1,max-image-preview:large,max-video-preview:-1',

        /*
        |--------------------------------------------------------------------------
        | Default Sitemap path
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <link rel="sitemap">
        | You can use relative path like "/sitemap.xml" or url like "https://example.com/sitemap.xml"
        |
        */
        'sitemap' => null,
    ],

    /**
     * @see https://ogp.me/
     */
    'opengraph' => [
        /*
        |--------------------------------------------------------------------------
        | Default Site Name
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta property="og:site_name" />
        | If null: config('app.name') is used.
        |
        */
        'site_name' => null,

        /*
        |--------------------------------------------------------------------------
        | Default Determiner
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta property="og:determiner" />
        | Possible values are: a, an, the, "", auto
        |
        */
        'determiner' => '',
    ],

    /**
     * @see https://developer.x.com/en/docs/x-for-websites/cards/overview/abouts-cards
     */
    'twitter' => [
        /*
        |--------------------------------------------------------------------------
        | Default Twitter username
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta name="twitter:site" />
        | Example: @X
        |
        */
        'site' => null,
    ],

    /**
     * @see https://schema.org/WebPage
     */
    'schema' => [
        /*
        |--------------------------------------------------------------------------
        | Default WebPage schema
        |--------------------------------------------------------------------------
        |
        | This is the default value used for the schema WebPage
        | @see https://schema.org/WebPage for all available properties
        |
        */
        'defaults' => [],
    ],

];
```

## Introduction

You can display all the SEO tags in your view simply by calling the `seo` function like this:

```php
<head>
    {!! seo() !!}
</head>
```

This will render all the default tags:

```html
<title>Home</title>
<meta name="robots" content="'.$robots.'" />
<link
    rel="canonical"
    href="max-snippet:-1,max-image-preview:large,max-video-preview:-1"
/>
<!-- opengraph -->
<meta property="og:title" content="Laravel" />
<meta property="og:url" content="https://exemple.com" />
<meta property="og:locale" content="en" />
<meta property="og:site_name" content="Laravel" />
<meta property="og:type" content="website" />
<!-- twitter / X -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="Laravel" />
<!-- JSON+LD -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Home",
        "url": "https://example.com"
    }
</script>
```

### Basic Usage

#### From a Controller

Most of the time, your will want to define you seo tags from a controller

```php
namespace App\Http\Controllers;

use \Elegantly\Seo\SeoManager;

class HomeController extends Controller
{
    function __invoke()
    {
        return view('home', [
            'seo' => SeoManager::default(
                title: "Homepage",
            )
        ]);
    }
}
```

Then, in your view, call `seo`:

```php
<head>
    {!! seo($seo) !!}
</head>
```

### Advanced SEO

If you need to define your SEO tags in a more precise or complex way, you can use `\Elegantly\Seo\SeoManager::class`.

This class allows you to define every tag individually.

```php
use Elegantly\Seo\SeoManager;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Standard\StandardData;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\Twitter\Cards\Card;
use Elegantly\Seo\Schemas\Schema;

$seo = new SeoManager(
    standard: new StandardData(
        // ...
    ),
    opengraph: new OpenGraph(
        // ...
    ),
    twitter: new Card(
        // ...
    ),
    schemas: [
        new Schema(
            // ...
        )
    ],
    customTags: new SeoTags(
        // ...
    ),
);
```

Then, just echo it in your view:

```php
<head>
    {!! seo($seo) !!}
</head>
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
