<?php

use Elegantly\Seo\OpenGraph\Image;
use Elegantly\Seo\OpenGraph\Locale;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\OpenGraph\Verticals\Website;
use Elegantly\Seo\SeoManager;
use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Standard\StandardData;
use Elegantly\Seo\Twitter\Cards\Summary;
use Elegantly\Seo\Twitter\Image as TwitterImage;

it('renders all standard, opengraph and twitter tags', function () {
    $manager = new SeoManager(
        standard: new StandardData(
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
        ),
        opengraph: new OpenGraph(
            title: 'Foo',
            image: new Image(
                url: 'https://example.com/opengraph/image',
                alt: 'Opengraph example image'
            ),
            url: 'https://example.com/opengraph',
            description: 'Bar',
            locale: new Locale(
                locale: 'en',
                alternate: ['en', 'fr']
            ),
            vertical: new Website
        ),
        twitter: new Summary(
            title: 'Foo',
            description: 'Bar',
            site: '@example',
            image: new TwitterImage(
                url: 'https://example.com/twitter/image',
                alt: 'Twitter example image'
            )
        ),
    );

    expect(
        $manager->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<title >Foo</title>',
        '<meta name="description" content="Bar" />',
        '<link rel="canonical" href="https://example.com/standard" />',
        '<link rel="alternate" hreflang="en" href="https://example.com/standard/en" />',
        '<link rel="alternate" hreflang="fr" href="https://example.com/standard/fr" />',
        //
        '<meta property="og:title" content="Foo" />',
        '<meta property="og:url" content="https://example.com/opengraph" />',
        '<meta property="og:image" content="https://example.com/opengraph/image" />',
        '<meta property="og:image:url" content="https://example.com/opengraph/image" />',
        '<meta property="og:image:alt" content="Opengraph example image" />',
        '<meta property="og:description" content="Bar" />',
        '<meta property="og:locale" content="en" />',
        '<meta property="og:locale:alternate" content="en" />',
        '<meta property="og:locale:alternate" content="fr" />',
        '<meta property="og:type" content="website" />',
        //
        '<meta name="twitter:card" content="summary" />',
        '<meta name="twitter:title" content="Foo" />',
        '<meta name="twitter:description" content="Bar" />',
        '<meta name="twitter:site" content="@example" />',
        '<meta name="twitter:image" content="https://example.com/twitter/image" />',
        '<meta name="twitter:image:alt" content="Twitter example image" />',
    ]));
});
