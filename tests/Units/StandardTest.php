<?php

use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Standard\StandardData;

it('renders standard tags', function () {
    $opengraph = new StandardData(
        title: 'Foo',
        canonical: 'https://example.com/standard',
        description: 'Bar',
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
        '<meta name="description" content="Bar" />',
        '<link rel="canonical" href="https://example.com/standard" />',
        '<link rel="alternate" hreflang="en" href="https://example.com/standard/en" />',
        '<link rel="alternate" hreflang="fr" href="https://example.com/standard/fr" />',
    ]));
});
