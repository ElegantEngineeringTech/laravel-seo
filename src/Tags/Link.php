<?php

declare(strict_types=1);

namespace Elegantly\Seo\Tags;

use Illuminate\Support\Collection;

final class Link extends TagVoid
{
    public string $tag = 'link';

    public function __construct(
        ?string $rel = null,
        ?string $hreflang = null,
        ?string $href = null,
        ?string $title = null,
        ?string $type = null,
        ?string $sizes = null,
    ) {
        $this->properties = Collection::make([
            'rel' => $rel,
            'hreflang' => $hreflang,
            'href' => $href,
            'title' => $title,
            'type' => $type,
            'sizes' => $sizes,
        ])->filter(fn (?string $item) => ! blank($item));
    }
}
