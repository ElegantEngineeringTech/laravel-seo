<?php

namespace Elegantly\Seo\Tags;

use Illuminate\Support\Collection;

class Script extends Tag
{
    public string $tag = 'script';

    protected bool $escape = false;

    public function __construct(
        public ?string $type = null,
        public ?string $content = null,
    ) {
        $this->properties = Collection::make([
            'type' => $type,
        ])->filter(fn (?string $item) => ! blank($item));
    }
}
