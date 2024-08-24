<?php

namespace Elegantly\Seo\Schemas;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Script;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

/**
 * @extends Collection<int|string, mixed>
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

    public static function default(): self
    {
        $schema = new self;

        return $schema->merge([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => __(config('seo.defaults.title')),
            'description' => __(config('seo.defaults.description')),
            'image' => config('seo.defaults.image.url'),
            'url' => Request::url(),
            ...config('seo.schema.defaults', []),
        ])->filter();
    }
}
