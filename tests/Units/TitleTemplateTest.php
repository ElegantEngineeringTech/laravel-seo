<?php

declare(strict_types=1);

use Elegantly\Seo\SeoManager;
use Elegantly\Seo\Standard\Standard;
use Elegantly\Seo\Tests\Fixtures\SeoDefaults;
use Illuminate\Support\Facades\App;

beforeEach(function () {
    config()->set('seo.defaults.title', 'My App');
    config()->set('seo.defaults.title_template', ':title | My App');
});

it('wraps the title set with setTitle in the template', function () {
    $html = SeoManager::default()->setTitle('Blog')->toHtml();

    expect($html)
        ->toContain('<title >Blog | My App</title>')
        ->not->toContain('titleTemplate');
});

it('only wraps the title tag', function () {
    $manager = SeoManager::default()->setTitle('Blog');

    expect($manager->standard->title)->toBe('Blog');

    expect($manager->toHtml())
        ->toContain('<meta property="og:title" content="Blog" />')
        ->toContain('<meta name="twitter:title" content="Blog" />')
        ->toContain('"name":"Blog"');
});

it('does not wrap the default title', function () {
    $manager = SeoManager::default();

    expect($manager->standard->titleTemplate)->toBeNull();
    expect($manager->toHtml())->toContain('<title >My App</title>');
});

it('does not wrap a title passed to the default manager', function () {
    expect(SeoManager::default(title: 'Blog')->toHtml())
        ->toContain('<title >Blog</title>');
});

it('renders the title as is when the template is false', function () {
    expect(SeoManager::default()->setTitle('My App: the best app', template: false)->toHtml())
        ->toContain('<title >My App: the best app</title>');
});

it('uses a custom template over the config', function () {
    expect(SeoManager::default()->setTitle('Installation', template: ':title · Docs · My App')->toHtml())
        ->toContain('<title >Installation · Docs · My App</title>');
});

it('renders titles as they are without a template in the config', function (?string $template) {
    config()->set('seo.defaults.title_template', $template);

    $manager = SeoManager::default()->setTitle('Blog');

    expect($manager->standard->titleTemplate)->toBeNull();
    expect($manager->toHtml())->toContain('<title >Blog</title>');
})->with([
    'null' => [null],
    'empty string' => [''],
]);

it('does not wrap the title twice when it is set again', function () {
    $manager = SeoManager::default()
        ->setTitle('Blog')
        ->setTitle('Post');

    expect($manager->toHtml())->toContain('<title >Post | My App</title>');
});

it('can change the template after the title is set', function () {
    $manager = SeoManager::default()->setTitle('Blog');

    $manager->standard->titleTemplate = ':title · Docs';

    expect($manager->toHtml())->toContain('<title >Blog · Docs</title>');
});

it('resolves a class and method template', function () {
    config()->set('seo.defaults.title_template', [SeoDefaults::class, 'titleTemplate']);

    App::setLocale('fr');

    expect(SeoManager::default()->setTitle('Blog')->toHtml())
        ->toContain('<title >Blog | App (fr)</title>');
});

it('escapes the title and leaves placeholders inside it alone', function () {
    expect(SeoManager::default()->setTitle('Tom & Jerry: 50% off :title')->toHtml())
        ->toContain('<title >Tom &amp; Jerry: 50% off :title | My App</title>');
});

it('does not render an empty title with the template', function () {
    expect(SeoManager::default()->setTitle('')->toHtml())
        ->not->toContain('<title');
});

it('renders a template set on the standard tags', function () {
    $standard = new Standard(
        title: 'Blog',
        canonical: 'https://example.com/blog',
        titleTemplate: ':title | My App',
    );

    expect($standard->toTags()->toHtml())->toBe(implode("\n", [
        '<title >Blog | My App</title>',
        '<link rel="canonical" href="https://example.com/blog" />',
    ]));
});

it('keeps the template when the manager is cloned', function () {
    $manager = SeoManager::default()->setTitle('Blog');

    $clone = clone $manager;
    $clone->setTitle('Post', template: false);

    expect($manager->toHtml())->toContain('<title >Blog | My App</title>');
    expect($clone->toHtml())->toContain('<title >Post</title>');
});
