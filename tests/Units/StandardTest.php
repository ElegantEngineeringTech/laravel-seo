<?php

declare(strict_types=1);

use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Standard\Standard;

it('renders standard tags', function () {
    $opengraph = new Standard(
        title: 'Foo',
        canonical: 'https://example.com/standard',
        description: 'Bar',
        keywords: ['foo', 'bar'],
        author: 'Quentin Gabriele',
        alternates: [
            new Alternate(
                hreflang: 'en',
                href: 'https://example.com/standard/en'
            ),
            new Alternate(
                hreflang: 'fr',
                href: 'https://example.com/standard/fr'
            ),
        ],
    );

    expect(
        $opengraph->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<title >Foo</title>',
        '<link rel="canonical" href="https://example.com/standard" />',
        '<meta name="author" content="Quentin Gabriele" />',
        '<meta name="description" content="Bar" />',
        '<meta name="keywords" content="foo,bar" />',
        '<link rel="alternate" hreflang="en" href="https://example.com/standard/en" />',
        '<link rel="alternate" hreflang="fr" href="https://example.com/standard/fr" />',
    ]));
});
