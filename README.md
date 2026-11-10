# An Elegant & Flexible SEO Tag Builder for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elegantly/laravel-seo.svg)](https://packagist.org/packages/elegantly/laravel-seo)
[![Total Downloads](https://img.shields.io/packagist/dt/elegantly/laravel-seo.svg)](https://packagist.org/packages/elegantly/laravel-seo)
[![Tests](https://github.com/ElegantEngineeringTech/laravel-seo/actions/workflows/run-tests.yml/badge.svg)](https://github.com/ElegantEngineeringTech/laravel-seo/actions/workflows/run-tests.yml)
[![Laravel Pint](https://github.com/ElegantEngineeringTech/laravel-seo/actions/workflows/pint.yml/badge.svg)](https://github.com/ElegantEngineeringTech/laravel-seo/actions/workflows/pint.yml)
[![PHPStan](https://github.com/ElegantEngineeringTech/laravel-seo/actions/workflows/phpstan.yml/badge.svg)](https://github.com/ElegantEngineeringTech/laravel-seo/actions/workflows/phpstan.yml)


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

    /*
    |--------------------------------------------------------------------------
    | Dynamic values
    |--------------------------------------------------------------------------
    |
    | Any value below can be computed at runtime, for example to depend on the
    | current locale. Use a class and method pair: [SeoDefaults::class, 'title'].
    | The method is called through the container and the config stays
    | compatible with "config:cache".
    |
    */

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
        | Default Title Template
        |--------------------------------------------------------------------------
        |
        | This template wraps the titles set with seo()->setTitle() in the <title> tag.
        | Use ":title" as the placeholder, for example ":title | My App".
        | The default title above, "og:title", "twitter:title" and the JSON-LD name
        | are never wrapped. Set to null to render titles as they are.
        |
        */
        'title_template' => null,

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
        | Default Image
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta property="og:image">, <meta name="twitter:image">
        | and the JSON-LD WebPage image. It must be an array with a "url" key: a relative path
        | like "/opengraph.png" or a url like "https://example.com/opengraph.png".
        | Optional keys: "type", "width", "height" and "alt".
        | Example: ['url' => '/opengraph.png', 'width' => '1200', 'height' => '630']
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

        /*
        |--------------------------------------------------------------------------
        | Default Video
        |--------------------------------------------------------------------------
        |
        | This is the default value used for <meta property="og:video" />, rendered next to the image.
        | iMessage plays it inline when the url points to a playable file, like an MPEG-4,
        | rather than to a page that embeds the video. Keep the file small: Messages limits
        | all preview assets (icons, images and videos) to 10 MB in total.
        | It must be an array with a "url" key: a relative path like "/opengraph.mp4"
        | or a url like "https://example.com/opengraph.mp4".
        | Optional keys: "secure_url", "type", "width" and "height".
        | Example: ['url' => '/opengraph.mp4', 'type' => 'video/mp4', 'width' => '1280', 'height' => '720']
        |
        */
        'video' => null,
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

### Dynamic Default Values

Any config value can be computed at runtime instead of being hard-coded, for example to depend on the current locale or tenant. Use a `[class, method]` pair:

```php
// config/seo.php
'defaults' => [
    'title' => [\App\Seo\SeoDefaults::class, 'title'],
    'description' => [\App\Seo\SeoDefaults::class, 'description'],
    'image' => [\App\Seo\SeoDefaults::class, 'image'],
    // ...
],
```

The method is called through the service container, so you can type-hint dependencies in its signature:

```php
namespace App\Seo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SeoDefaults
{
    public function title(Request $request): string
    {
        return $request->user()?->team->name ?? config('app.name');
    }

    public function description(): string
    {
        return __('seo.description');
    }

    public static function image(): array
    {
        return [
            'url' => '/images/opengraph-'.App::getLocale().'.png',
            'alt' => __('seo.image_alt'),
        ];
    }
}
```

An array is treated as a `[class, method]` pair only when its first item is an existing class. Other arrays, like a list of keywords, are used as is.

Config values are never translated automatically: to use translation strings, return them from a method with `__()` as shown above.

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
            ->setVideo(asset('videos/opengraph.mp4'))
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

### Title Templates

To add your brand to every page title, set a template in the config, with `:title` as the placeholder:

```php
// config/seo.php
'defaults' => [
    'title' => 'My App',
    'title_template' => ':title | My App',
],
```

Titles set with `setTitle()` are then wrapped in the `<title>` tag:

```php
seo()->setTitle('Blog');
```

```html
<title>Blog | My App</title>
<meta property="og:title" content="Blog" />
<meta name="twitter:title" content="Blog" />
```

Only the `<title>` tag is wrapped: social networks already show the site name from `og:site_name`, and the JSON-LD `name` is the name of the page itself. The default title is never wrapped either, so a page that doesn't call `setTitle()` shows `My App`, not `My App | My App`.

You can render a title as is, or use another template for a single page:

```php
seo()->setTitle('My App: the best app', template: false);
// <title>My App: the best app</title>

seo()->setTitle('Installation', template: ':title · Docs · My App');
// <title>Installation · Docs · My App</title>
```

Like any other config value, the template can be computed at runtime, for example to depend on the section of your site or on the current locale:

```php
// config/seo.php
'title_template' => [\App\Seo\SeoDefaults::class, 'titleTemplate'],
```

```php
public function titleTemplate(Request $request): string
{
    if ($request->routeIs('docs.*')) {
        return ':title · Docs · '.config('app.name');
    }

    return ':title | '.config('app.name');
}
```

### Video Previews in iMessage

When a link is shared in Messages, iMessage can play a video inline in the preview instead of showing a still image. Use `setVideo()` to add an `og:video` tag next to your `og:image`:

```php
use Elegantly\Seo\SeoVideo;

seo()
    ->setImage(asset('images/opengraph.jpg'))
    ->setVideo(asset('videos/opengraph.mp4'));

// Or with every og:video property
seo()->setVideo(new SeoVideo(
    url: asset('videos/opengraph.mp4'),
    type: 'video/mp4',
    width: '1280',
    height: '720',
));
```

This renders:

```html
<meta property="og:image" content="https://example.com/images/opengraph.jpg" />
<meta property="og:image:url" content="https://example.com/images/opengraph.jpg" />
<meta property="og:video" content="https://example.com/videos/opengraph.mp4" />
<meta property="og:video:url" content="https://example.com/videos/opengraph.mp4" />
<meta property="og:video:type" content="video/mp4" />
<meta property="og:video:width" content="1280" />
<meta property="og:video:height" content="720" />
```

Keep the image: apps that don't play videos still show it. Following [Apple's guidelines](https://developer.apple.com/documentation/technotes/tn3156-create-rich-previews-for-messages), the video should be:

-   A direct link to a playable file, like an MPEG-4. Links to a page that embeds the video won't play inline, and streams like HLS need a tap to start.
-   Small: Messages limits all the preview assets (icons, images and videos) to 10 MB in total.

To use the same video on every page, set `opengraph.video` in the config file.

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
