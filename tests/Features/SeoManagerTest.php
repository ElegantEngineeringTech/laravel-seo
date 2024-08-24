<?php

use Elegantly\Seo\Facades\SeoManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

it('renders default seo from config using Facade', function () {

    $data = SeoManager::make();

    $url = Request::url();
    $locale = App::getLocale();
    $robots = config('seo.defaults.robots');

    expect(
        $data->toTags()->toHtml()
    )->toBe(implode("\n", [
        // standard
        '<title >Laravel</title>',
        '<meta name="robots" content="'.$robots.'" />',
        '<link rel="canonical" href="'.$url.'" />',
        // opengraph
        '<meta property="og:title" content="Laravel" />',
        '<meta property="og:url" content="'.$url.'" />',
        '<meta property="og:locale" content="'.$locale.'" />',
        '<meta property="og:site_name" content="'.config('app.name').'" />',
        '<meta property="og:type" content="website" />',
        // twitter
        '<meta name="twitter:card" content="summary" />',
        '<meta name="twitter:title" content="Laravel" />',
        // JSON
        '<script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"WebPage","name":"Laravel","url":"http:\/\/localhost"}</script>',
    ]));
});
