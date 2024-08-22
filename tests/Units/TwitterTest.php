<?php

use Elegantly\Seo\Twitter\Cards\Summary;
use Elegantly\Seo\Twitter\Cards\SummaryLargeImage;
use Elegantly\Seo\Twitter\Image;

it('renders twitter summary tags', function () {
    $twitter = new Summary(
        title: 'Foo',
        description: 'Bar',
        site: '@example',
        image: new Image(
            url: 'https://example.com/twitter/image',
            alt: 'Twitter example image'
        )
    );

    expect(
        $twitter->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<meta name="twitter:card" content="summary" />',
        '<meta name="twitter:title" content="Foo" />',
        '<meta name="twitter:description" content="Bar" />',
        '<meta name="twitter:site" content="@example" />',
        '<meta name="twitter:image" content="https://example.com/twitter/image" />',
        '<meta name="twitter:image:alt" content="Twitter example image" />',
    ]));
});

it('renders twitter summary_large_image tags', function () {
    $twitter = new SummaryLargeImage(
        title: 'Foo',
        description: 'Bar',
        site: '@example',
        image: new Image(
            url: 'https://example.com/twitter/image',
            alt: 'Twitter example image'
        )
    );

    expect(
        $twitter->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<meta name="twitter:card" content="summary_large_image" />',
        '<meta name="twitter:title" content="Foo" />',
        '<meta name="twitter:description" content="Bar" />',
        '<meta name="twitter:site" content="@example" />',
        '<meta name="twitter:image" content="https://example.com/twitter/image" />',
        '<meta name="twitter:image:alt" content="Twitter example image" />',
    ]));
});
