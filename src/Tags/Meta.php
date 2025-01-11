<?php

declare(strict_types=1);

namespace Elegantly\Seo\Tags;

use Illuminate\Support\Collection;

class Meta extends TagVoid
{
    public string $tag = 'meta';

    public function __construct(
        ?string $name = null,
        ?string $property = null,
        ?string $content = null,
        ?string $charset = null,
    ) {
        $this->properties = Collection::make([
            'name' => $name,
            'property' => $property,
            'content' => $content,
            'charset' => $charset,
        ])->filter(fn (?string $item) => ! blank($item));
    }
}
