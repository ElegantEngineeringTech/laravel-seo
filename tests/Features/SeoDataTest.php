<?php

use Elegantly\Seo\Facades\SeoManager;
use Elegantly\Seo\SeoData;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

it('renders default seo from config', function () {

    $data = new SeoData;

    $url = URL::current();
    $locale = App::getLocale();
    $robots = config('seo.robots');

    expect(
        $data->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<title >Laravel</title>',
        '<meta name="robots" content="'.$robots.'" />',
        '<link rel="canonical" href="'.$url.'" />',
        '<meta property="og:type" content="website" />',
        '<meta property="og:title" content="Laravel" />',
        '<meta property="og:url" content="'.$url.'" />',
        '<meta property="og:locale" content="'.$locale.'" />',
        '<meta name="twitter:card" content="summary" />',
        '<meta name="twitter:title" content="Laravel" />',
    ]));
});

it('renders default seo from config using Facade', function () {

    $data = SeoManager::from();

    $url = URL::current();
    $locale = App::getLocale();
    $robots = config('seo.robots');

    expect(
        $data->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<title >Laravel</title>',
        '<meta name="robots" content="'.$robots.'" />',
        '<link rel="canonical" href="'.$url.'" />',
        '<meta property="og:type" content="website" />',
        '<meta property="og:title" content="Laravel" />',
        '<meta property="og:url" content="'.$url.'" />',
        '<meta property="og:locale" content="'.$locale.'" />',
        '<meta name="twitter:card" content="summary" />',
        '<meta name="twitter:title" content="Laravel" />',
    ]));
});
