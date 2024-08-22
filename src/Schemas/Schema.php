<?php

namespace Elegantly\Seo\Schemas;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Script;
use Illuminate\Support\Collection;

/**
 * @extends Collection<string, null|int|float|string|array|Schema>
 */
class Schema extends Collection implements Taggable
{
    public function toTags(): SeoTags
    {
        return new SeoTags([
            new Script(
                type: 'application/ld+json',
                content: $this->toJson(),
            ),
        ]);
    }
}
