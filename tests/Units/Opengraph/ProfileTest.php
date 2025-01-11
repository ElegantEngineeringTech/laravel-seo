<?php

declare(strict_types=1);

use Elegantly\Seo\OpenGraph\Verticals\Profile;

it('renders opengraph profile tags', function () {

    $profile = new Profile(
        first_name: 'Foo',
        last_name: 'Bar',
        username: 'foobar',
        gender: 'male'
    );

    expect(
        $profile->toTags()->toHtml()
    )->toBe(implode("\n", [
        '<meta property="og:type" content="profile" />',
        '<meta property="profile:first_name" content="Foo" />',
        '<meta property="profile:last_name" content="Bar" />',
        '<meta property="profile:username" content="foobar" />',
        '<meta property="profile:gender" content="male" />',
    ]));
});
