<?php

use Elegantly\Seo\Tags\Link;
use Elegantly\Seo\Tags\Meta;
use Elegantly\Seo\Tags\Title;

it('renders a void meta tag', function () {
    $tag = new Meta(
        name: 'foo',
        content: 'bar'
    );
    expect(
        $tag->toHtml()
    )->toBe('<meta name="foo" content="bar" />');
});

it('renders a void link tag', function () {
    $tag = new Link(
        rel: 'foo',
        title: 'bar',
    );
    expect(
        $tag->toHtml()
    )->toBe('<link rel="foo" title="bar" />');
});

it('renders a title tag', function () {
    $tag = new Title(
        content: 'bar',
    );
    expect(
        $tag->toHtml()
    )->toBe('<title >bar</title>');
});
