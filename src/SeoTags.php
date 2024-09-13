<?php

namespace Elegantly\Seo;

use Elegantly\Seo\Tags\TagVoid;
use Elegantly\Seo\Traits\DeepClone;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

/**
 * @extends Collection<int, TagVoid>
 */
class SeoTags extends Collection implements Htmlable
{
    use DeepClone;

    public function toHtml(): string
    {
        return $this->map(fn (TagVoid $tag) => $tag->toHtml())->join("\n");
    }
}
