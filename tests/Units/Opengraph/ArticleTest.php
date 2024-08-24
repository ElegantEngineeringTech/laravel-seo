<?php

use Carbon\Carbon;
use Elegantly\Seo\OpenGraph\Verticals\Article;
use Elegantly\Seo\OpenGraph\Verticals\Profile;

it('renders opengraph article tags', function () {
    $published_time = Carbon::create(2024, 8, 1);
    $modified_time = Carbon::create(2024, 8, 24);
    $expiration_time = Carbon::create(2024, 8, 31);

    $article = new Article(
        published_time: $published_time,
        modified_time: $modified_time,
        expiration_time: $expiration_time,
        author: [
            'https://example.com/author',
            new Profile(
                first_name: 'Foo',
                last_name: 'Bar',
                username: 'foobar',
                gender: 'male'
            ),
        ],
        section: 'France',
        tag: ['foo', 'bar'],
    );

    expect(
        $article->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<meta property="og:type" content="article" />',
        '<meta property="article:published_time" content="2024-08-01T00:00:00+00:00" />',
        '<meta property="article:modified_time" content="2024-08-24T00:00:00+00:00" />',
        '<meta property="article:expiration_time" content="2024-08-31T00:00:00+00:00" />',
        '<meta property="article:author" content="https://example.com/author" />',
        '<meta property="article:author:first_name" content="Foo" />',
        '<meta property="article:author:last_name" content="Bar" />',
        '<meta property="article:author:username" content="foobar" />',
        '<meta property="article:author:gender" content="male" />',
        '<meta property="article:section" content="France" />',
        '<meta property="article:tag" content="foo" />',
        '<meta property="article:tag" content="bar" />',
    ]));
});
