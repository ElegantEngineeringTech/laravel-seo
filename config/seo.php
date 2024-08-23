<?php

// config for Elegantly/Seo
return [

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



];
