<?php

use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Unified\Image;
use Elegantly\Seo\Unified\SeoUnifiedData;

it('renders all standard, opengrpah and twitter tags', function () {
    $data = new SeoUnifiedData(
        title: 'Foo',
        canonical: 'https://example.com',
        description: 'Bar',
        locale: 'en',
        alternates: [
            new Alternate(
                hreflang: 'en',
                href: 'https://example.com/en'
            ),
            new Alternate(
                hreflang: 'fr',
                href: 'https://example.com/fr'
            ),
        ],
        image: new Image(
            url: 'https://example.com/image',
            alt: 'Example image'
        ),
    );

    expect(
        $data->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<title >Foo</title>',
        '<meta name="description" content="Bar" />',
        '<link rel="canonical" href="https://example.com" />',
        '<link rel="alternate" hreflang="en" href="https://example.com/en" />',
        '<link rel="alternate" hreflang="fr" href="https://example.com/fr" />',
        //
        '<meta property="og:title" content="Foo" />',
        '<meta property="og:url" content="https://example.com" />',
        '<meta property="og:image" content="https://example.com/image" />',
        '<meta property="og:image:url" content="https://example.com/image" />',
        '<meta property="og:image:alt" content="Example image" />',
        '<meta property="og:description" content="Bar" />',
        '<meta property="og:locale" content="en" />',
        '<meta property="og:locale:alternate" content="en" />',
        '<meta property="og:locale:alternate" content="fr" />',
        '<meta property="og:type" content="website" />',
        //
        '<meta name="twitter:card" content="summary" />',
        '<meta name="twitter:title" content="Foo" />',
        '<meta name="twitter:description" content="Bar" />',
        '<meta name="twitter:image" content="https://example.com/image" />',
        '<meta name="twitter:image:alt" content="Example image" />',
    ]));
});
