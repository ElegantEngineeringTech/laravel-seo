<?php

declare(strict_types=1);

use Elegantly\Seo\OpenGraph\Image;
use Elegantly\Seo\OpenGraph\Locale;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\OpenGraph\Verticals\Website;
use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\Schemas\WebPage;
use Elegantly\Seo\SeoManager;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Standard\Standard;
use Elegantly\Seo\Tags\Meta;
use Elegantly\Seo\Twitter\Cards\Summary;
use Elegantly\Seo\Twitter\Image as TwitterImage;

it('renders all standard, opengraph and twitter tags', function () {
    $manager = new SeoManager(
        standard: new Standard(
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
        '<link rel="canonical" href="https://example.com/standard" />',
        '<meta name="description" content="Bar" />',
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

it('can clone itself with new references', function () {
    $base = new SeoManager(
        standard: new Standard(
            title: 'foo',
            canonical: 'bar',
            alternates: [
                new Alternate(
                    hreflang: 'foo',
                    href: 'bar'
                ),
            ]
        ),
        opengraph: new OpenGraph(
            title: 'foo',
            url: 'bar',
            image: new Image(
                url: 'foo',
            )
        ),
        twitter: new Summary(
            title: 'foo',
        ),
        webpage: new WebPage,
        schemas: [
            new Schema,
        ],
        customTags: new SeoTags([
            new Meta(
                name: 'foo',
                content: 'bar'
            ),
        ])
    );

    $clone = clone $base;

    expect($clone)->not->toBe($base);

    expect($clone->standard)->not->toBe($base->standard);
    expect($clone->opengraph)->not->toBe($base->opengraph);
    expect($clone->twitter)->not->toBe($base->twitter);
    expect($clone->webpage)->not->toBe($base->webpage);
    expect($clone->schemas)->not->toBe($base->schemas);
    expect($clone->schemas[0])->not->toBe($base->schemas[0]);
    expect($clone->customTags)->not->toBe($base->customTags);
    expect($clone->customTags[0])->not->toBe($base->customTags[0]);
    expect($clone->customTags[0]->properties)->not->toBe($base->customTags[0]->properties);
});

it('can set alternates using assoc array', function () {
    $manager = new SeoManager(
        standard: new Standard(
            title: 'foo',
            canonical: 'bar',
        ),
        opengraph: new OpenGraph(
            title: 'foo',
            url: 'bar',
        ),
    );

    $manager->setAlternates([
        'fr' => 'example.com/fr',
        'en' => 'example.com/en',
        'x-default' => 'example.com/en',
    ]);

    expect($manager->standard->alternates)->toHaveLength(3);
    expect($manager->standard->alternates[0]->hreflang)->toBe('fr');
    expect($manager->standard->alternates[0]->href)->toBe('example.com/fr');
});

it('converts html descriptions to plain text', function (?string $input, ?string $expected) {
    $manager = SeoManager::default()->setDescription($input);

    expect($manager->standard->description)->toBe($expected);
    expect($manager->opengraph->description)->toBe($expected);
    expect($manager->twitter->description)->toBe($expected);
    expect($manager->webpage->get('description'))->toBe($expected);
})->with([
    'block tags become spaces' => ['<p>Foo</p><p>Bar<br>Baz</p>', 'Foo Bar Baz'],
    'entities are decoded' => ['Tom &amp; Jerry&#039;s &quot;show&quot;', 'Tom & Jerry\'s "show"'],
    'encoded markup is stripped' => ['<p>Use &lt;script&gt;alert(1)&lt;/script&gt; here</p>', 'Use alert(1) here'],
    'encoded comment opener is stripped' => ['<p>Tips &lt;!--&lt;script&gt; for devs</p>', 'Tips'],
    'null stays null' => [null, null],
    'markup only becomes null' => ['<p></p>', null],
]);

it('limits the description length while preserving words', function () {
    $manager = SeoManager::default()->setDescription(str_repeat('word ', 50), limit: 22);

    expect($manager->standard->description)->toBe('word word word word...');
});

it('does not limit the description when limit is 0', function () {
    $description = trim(str_repeat('word ', 50));

    $manager = SeoManager::default()->setDescription($description, limit: 0);

    expect($manager->standard->description)->toBe($description);
});
