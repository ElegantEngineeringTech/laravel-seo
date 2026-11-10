<?php

declare(strict_types=1);

use Elegantly\Seo\SeoConfig;
use Elegantly\Seo\SeoManager;
use Elegantly\Seo\Tests\Fixtures\SeoDefaults;
use Illuminate\Support\Facades\App;

it('resolves a class and method each time the value is read', function () {
    config()->set('seo.defaults.description', [SeoDefaults::class, 'description']);

    App::setLocale('fr');
    expect(SeoConfig::get('defaults.description'))->toBe('Description en français');

    App::setLocale('en');
    expect(SeoConfig::get('defaults.description'))->toBe('English description');
});

it('injects method dependencies', function () {
    config()->set('seo.defaults.title', [SeoDefaults::class, 'title']);

    App::setLocale('fr');

    expect(SeoConfig::get('defaults.title'))->toBe('Title (fr)');
});

it('resolves a static method', function () {
    config()->set('seo.defaults.image', [SeoDefaults::class, 'image']);

    expect(SeoConfig::get('defaults.image'))->toBe(SeoDefaults::image());
});

it('returns null for missing keys', function () {
    expect(SeoConfig::get('defaults.missing'))->toBeNull();
    expect(SeoConfig::get('missing.nested.key'))->toBeNull();
});

it('leaves regular values untouched', function (mixed $value) {
    config()->set('seo.defaults.keywords', $value);

    expect(SeoConfig::get('defaults.keywords'))->toBe($value);
})->with([
    'string' => 'My App',
    'class name string' => SeoDefaults::class,
    'list of keywords' => [['seo', 'laravel']],
    'image array' => [['url' => 'https://example.com/image.png', 'alt' => 'Alt']],
    'empty array' => [[]],
]);

it('renders dynamic defaults in every tag', function () {
    config()->set('seo.defaults.title', [SeoDefaults::class, 'title']);
    config()->set('seo.defaults.description', [SeoDefaults::class, 'description']);
    config()->set('seo.defaults.image', [SeoDefaults::class, 'image']);

    App::setLocale('fr');

    $html = SeoManager::default()->toHtml();

    expect($html)
        ->toContain('<title >Title (fr)</title>')
        ->toContain('<meta name="description" content="Description en français" />')
        ->toContain('<meta property="og:title" content="Title (fr)" />')
        ->toContain('<meta property="og:description" content="Description en français" />')
        ->toContain('<meta property="og:image" content="https://example.com/opengraph.png" />')
        ->toContain('<meta property="og:image:alt" content="Default alt" />')
        ->toContain('<meta name="twitter:title" content="Title (fr)" />')
        ->toContain('<meta name="twitter:image" content="https://example.com/opengraph.png" />')
        ->toContain('<meta name="twitter:image:alt" content="Default alt" />')
        ->toContain('"image":"https:\/\/example.com\/opengraph.png"');
});

it('lets scoped image values override the default image', function () {
    config()->set('seo.defaults.image', [SeoDefaults::class, 'image']);
    config()->set('seo.opengraph.image', ['alt' => 'Open Graph alt', 'width' => '1200']);

    $html = SeoManager::default()->toHtml();

    expect($html)
        ->toContain('<meta property="og:image" content="https://example.com/opengraph.png" />')
        ->toContain('<meta property="og:image:width" content="1200" />')
        ->toContain('<meta property="og:image:alt" content="Open Graph alt" />')
        ->toContain('<meta name="twitter:image:alt" content="Default alt" />');
});

it('does not translate config values', function () {
    app('translator')->addLines(['seo.title' => 'Translated title'], 'en');

    config()->set('seo.defaults.title', 'seo.title');
    config()->set('seo.defaults.description', 'seo.title');

    $html = SeoManager::default()->toHtml();

    expect($html)
        ->not->toContain('Translated title')
        ->toContain('<meta property="og:title" content="seo.title" />')
        ->toContain('<meta property="og:description" content="seo.title" />')
        ->toContain('<meta name="twitter:title" content="seo.title" />')
        ->toContain('"name":"seo.title"');
});

it('makes relative image paths absolute', function () {
    config()->set('seo.defaults.image', ['url' => '/images/opengraph.png']);

    expect(SeoManager::default()->toHtml())
        ->toContain('<meta property="og:image" content="'.asset('/images/opengraph.png').'" />');
});

it('renders no default image without a url', function () {
    config()->set('seo.defaults.image', ['alt' => 'Alt without url']);

    expect(SeoManager::default()->toHtml())
        ->not->toContain('og:image')
        ->not->toContain('twitter:image')
        ->not->toContain('"image"');
});

it('requires images to be arrays', function () {
    config()->set('seo.defaults.image', '/images/opengraph.png');

    SeoManager::default();
})->throws(TypeError::class);

it('renders the default video next to the default image', function () {
    config()->set('seo.defaults.image', [SeoDefaults::class, 'image']);
    config()->set('seo.opengraph.video', [SeoDefaults::class, 'video']);

    expect(SeoManager::default()->toHtml())
        ->toContain('<meta property="og:image" content="https://example.com/opengraph.png" />')
        ->toContain('<meta property="og:video" content="https://example.com/opengraph.mp4" />')
        ->toContain('<meta property="og:video:type" content="video/mp4" />');
});

it('makes relative video paths absolute', function () {
    config()->set('seo.opengraph.video', ['url' => '/videos/opengraph.mp4']);

    expect(SeoManager::default()->toHtml())
        ->toContain('<meta property="og:video" content="'.asset('/videos/opengraph.mp4').'" />');
});

it('renders no default video without a url', function () {
    config()->set('seo.opengraph.video', ['type' => 'video/mp4']);

    expect(SeoManager::default()->toHtml())->not->toContain('og:video');
});

it('renders no default video by default', function () {
    expect(SeoManager::default()->toHtml())->not->toContain('og:video');
});
