<?php

use Elegantly\Seo\OpenGraph\Image;
use Elegantly\Seo\OpenGraph\Locale;
use Elegantly\Seo\OpenGraph\Verticals\Website;

it('renders opengraph website tags', function () {
    $opengraph = new Website(
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
        '<meta property="og:type" content="website" />',
        '<meta property="og:title" content="Foo" />',
        '<meta property="og:url" content="https://example.com/opengraph" />',
        '<meta property="og:image" content="https://example.com/opengraph/image" />',
        '<meta property="og:image:url" content="https://example.com/opengraph/image" />',
        '<meta property="og:image:alt" content="Opengraph example image" />',
        '<meta property="og:description" content="Bar" />',
        '<meta property="og:locale" content="en" />',
        '<meta property="og:locale:alternate" content="fr" />',
        '<meta property="og:locale:alternate" content="it" />',
    ]));
});
