<?php

use Carbon\Carbon;
use Elegantly\Seo\OpenGraph\Verticals\Book;
use Elegantly\Seo\OpenGraph\Verticals\Profile;

it('renders opengraph book tags', function () {
    $release_date = Carbon::create(2024, 8, 1);

    $book = new Book(
        author: [
            'https://example.com/author',
            new Profile(
                first_name: 'Foo',
                last_name: 'Bar',
                username: 'foobar',
                gender: 'male'
            ),
        ],
        isbn: 'foo',
        release_date: $release_date,
        tag: ['foo', 'bar'],
    );

    expect(
        $book->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<meta property="og:type" content="book" />',
        '<meta property="book:author" content="https://example.com/author" />',
        '<meta property="book:author:first_name" content="Foo" />',
        '<meta property="book:author:last_name" content="Bar" />',
        '<meta property="book:author:username" content="foobar" />',
        '<meta property="book:author:gender" content="male" />',
        '<meta property="book:isbn" content="foo" />',
        '<meta property="book:release_date" content="2024-08-01T00:00:00+00:00" />',
        '<meta property="book:tag" content="foo" />',
        '<meta property="book:tag" content="bar" />',
    ]));
});
