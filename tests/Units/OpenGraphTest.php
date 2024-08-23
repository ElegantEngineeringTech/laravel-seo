<?php

use Elegantly\Seo\OpenGraph\Image;
use Elegantly\Seo\OpenGraph\Locale;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\OpenGraph\Verticals\Article;

it('renders opengraph website tags', function () {
    $opengraph = new OpenGraph(
        title: 'Foo',
        image: new Image(
            url: 'https://example.com/opengraph/image',
            alt: 'Opengraph example image'
        ),
        url: 'https://example.com/opengraph',
        description: 'Bar',
        locale: new Locale(
            locale: 'en',
            alternate: ['fr', 'it']
        )

    );

    expect(
        $opengraph->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<meta property="og:title" content="Foo" />',
        '<meta property="og:url" content="https://example.com/opengraph" />',
        '<meta property="og:image" content="https://example.com/opengraph/image" />',
        '<meta property="og:image:url" content="https://example.com/opengraph/image" />',
        '<meta property="og:image:alt" content="Opengraph example image" />',
        '<meta property="og:description" content="Bar" />',
        '<meta property="og:locale" content="en" />',
        '<meta property="og:locale:alternate" content="fr" />',
        '<meta property="og:locale:alternate" content="it" />',
        '<meta property="og:type" content="website" />',
    ]));
});

it('renders opengraph article tags', function () {
    $now = now();
    $opengraph = new OpenGraph(
        title: 'Foo',
        image: new Image(
            url: 'https://example.com/opengraph/image',
            alt: 'Opengraph example image'
        ),
        url: 'https://example.com/opengraph',
        description: 'Bar',
        locale: new Locale(
            locale: 'en',
            alternate: ['fr', 'it']
        ),
        vertical: new Article(
            published_time: $now,
            modified_time: $now,
            expiration_time: $now,
            section: 'US',
            tag: ['foo', 'bar'],
        )
    );

    expect(
        $opengraph->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<meta property="og:title" content="Foo" />',
        '<meta property="og:url" content="https://example.com/opengraph" />',
        '<meta property="og:image" content="https://example.com/opengraph/image" />',
        '<meta property="og:image:url" content="https://example.com/opengraph/image" />',
        '<meta property="og:image:alt" content="Opengraph example image" />',
        '<meta property="og:description" content="Bar" />',
        '<meta property="og:locale" content="en" />',
        '<meta property="og:locale:alternate" content="fr" />',
        '<meta property="og:locale:alternate" content="it" />',
        '<meta property="og:type" content="article" />',
        '<meta property="article:published_time" content="'.$now->toAtomString().'" />',
        '<meta property="article:modified_time" content="'.$now->toAtomString().'" />',
        '<meta property="article:expiration_time" content="'.$now->toAtomString().'" />',
        '<meta property="article:section" content="US" />',
        '<meta property="article:tag" content="foo" />',
        '<meta property="article:tag" content="bar" />',
    ]));
});
