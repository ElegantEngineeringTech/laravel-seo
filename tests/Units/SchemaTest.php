<?php

declare(strict_types=1);

use Elegantly\Seo\Schemas\Schema;

it('escapes html tag characters in json-ld output', function () {
    $data = [
        '@context' => 'https://schema.org',
        'name' => 'Tips <!--<script> for devs </script><script>alert(1)</script>',
    ];

    $html = (new Schema($data))->toTags()->toHtml();

    $content = str($html)
        ->after('<script type="application/ld+json">')
        ->beforeLast('</script>')
        ->value();

    expect($content)
        ->not->toContain('<')
        ->not->toContain('>')
        ->and(json_decode($content, true))->toBe($data);
});
