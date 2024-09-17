# An Elegant & Flexible SEO Tag Builder for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elegantly/laravel-seo.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-seo)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/elegantengineeringtech/laravel-seo/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/elegantengineeringtech/laravel-seo/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/elegantengineeringtech/laravel-seo/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/elegantengineeringtech/laravel-seo/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/elegantly/laravel-seo.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-seo)

![laravel-seo](https://repository-images.githubusercontent.com/845966143/6ff7437c-852d-41eb-8b2f-927551506a13)

## Introduction

`laravel-seo` is a flexible and powerful package for managing SEO tags in Laravel applications.

With this package, you can easily handle:

-   Standard HTML tags like `<title>` and `<meta name="robots">`
-   Localization with alternate tags ([Google SEO Localization](https://developers.google.com/search/docs/specialty/international/localized-versions))
-   [Open Graph tags](https://ogp.me/) with structured properties, arrays, and object types
-   [Twitter (X) tags](https://developer.x.com/en/docs/x-for-websites/cards/overview/abouts-cards)
-   [Structured data (JSON-LD)](https://developers.google.com/search/docs/appearance/structured-data/intro-structured-data)

## Installation

You can install the package via Composer:

```bash
composer require elegantly/laravel-seo
```

Next, publish the config file:

```bash
php artisan vendor:publish --tag="seo-config"
```

### Config File Overview

The configuration file (`config/seo.php`) allows you to customize the default SEO behavior for your application. Here's a snippet with all available settings:

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
        | This is the default value used for <meta name="description">,
        | <meta property="og:description">, <meta name="twitter:description">
        |
        */
        'description' => null,

        /*
        |--------------------------------------------------------------------------
        | Default Author
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta name="author">
        |
        */
        'author' => null,

        /*
        |--------------------------------------------------------------------------
        | Default Generator
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta name="generator">
        |
        */
        'generator' => null,

        /*
        |--------------------------------------------------------------------------
        | Default Keywords
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta name="keywords">
        | Types supported: string or array of strings
        |
        */
        'keywords' => null,

        /*
        |--------------------------------------------------------------------------
        | Default Referrer
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta name="referrer">
        |
        */
        'referrer' => null,

        /*
        |--------------------------------------------------------------------------
        | Default Theme color
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta name="theme-color">
        |
        */
        'theme-color' => null,

        /*
        |--------------------------------------------------------------------------
        | Default Color Scheme
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta name="color-scheme">
        |
        */
        'color-scheme' => null,

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
        'webpage' => [],
    ],

];
```

## Usage

### Displaying SEO Tags

You can easily render all SEO tags in your Blade views by calling the `seo()` helper function:

```php
<head>
    {!! seo() !!}
</head>
```

This will render all the default tags, for example:

```html
<title>Home</title>
<meta
    name="robots"
    content="max-snippet:-1,max-image-preview:large,max-video-preview:-1"
/>
<link rel="canonical" href="https://example.com" />
<!-- Open Graph -->
<meta property="og:title" content="Home" />
<meta property="og:url" content="https://example.com" />
<meta property="og:locale" content="en" />
<meta property="og:site_name" content="My App" />
<meta property="og:type" content="website" />
<!-- Twitter (X) -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="Home" />
<!-- JSON-LD -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Home",
        "url": "https://example.com"
    }
</script>
```

### Setting SEO Tags in Controllers

You will typically want to define your SEO tags dynamically in your controllers. You can do this using either the `seo()` helper or the `SeoManager` facade:

```php
namespace App\Http\Controllers;

use \Elegantly\Seo\Facades\SeoManager;
use Elegantly\Seo\Standard\Alternate;

class HomeController extends Controller
{
    public function __invoke()
    {
        // Using the helper
        seo()
            ->setTitle("Homepage")
            ->setImage(asset('images/opengraph.jpg'))
            ->setDescription("The homepage description")
            ->when(!App::isProduction(), fn($seo) => $seo->noIndex())
            ->setLocale("fr")
            ->setAlternates([
                new Alternate(
                    hreflang: "en",
                    href: route('home', ['locale' => "en"]),
                ),
                new Alternate(
                    hreflang: "fr",
                    href: route('home', ['locale' => "fr"]),
                ),
            ])
            ->setOpengraph(function(OpenGraph $opengraph){
                $opengraph->title = "Custom opengraph title";
                return $opengraph;
            });

        // Using the facade
        SeoManager::current()
            ->setTitle("Homepage")
            ->setDescription("The homepage description");
            // ...

        return view('home');
    }
}
```

Then, in your Blade view, just render the tags like this:

```html
<head>
    {!! seo() !!}
</head>
```

### Advanced Usage

For more complex SEO needs, you can instantiate and configure the `SeoManager` class directly. This gives you full control over every tag, including Open Graph, Twitter, JSON-LD, and custom schema tags.

```php
use Elegantly\Seo\SeoManager;
use Elegantly\Seo\Standard\Standard;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\Twitter\Cards\Card;
use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\SeoTags;

$seo = new SeoManager(
    standard: new Standard(/* ... */),
    opengraph: new OpenGraph(/* ... */),
    twitter: new Card(/* ... */),
    webpage: new WebPage(/* ... */),
    schemas: [/* ... */],
    customTags: new SeoTags(/* ... */)
);
```

Then, in your Blade view:

```html
<head>
    {!! $seo !!}
</head>
```

## Testing

To run the tests:

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for details on recent updates.

## Contributing

See [CONTRIBUTING](CONTRIBUTING.md) for guidelines on contributing to this project.

## Security

Please refer to our [security policy](../../security/policy) for reporting vulnerabilities.

## Credits

-   [Quentin Gabriele](https://github.com/QuentinGab)
-   [All Contributors](../../contributors)

## License

This package is licensed under the [MIT License](LICENSE.md).
