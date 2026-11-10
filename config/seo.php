<?php

declare(strict_types=1);

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
