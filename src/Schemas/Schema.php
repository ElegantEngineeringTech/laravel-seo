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

    public static function default(
        ?string $title = null,
        ?string $url = null,
        ?string $description = null,
        ?string $image = null,
    ): self {
        $schema = new self([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => __(config('seo.defaults.title')),
            'description' => __(config('seo.defaults.description')),
            'image' => config('seo.defaults.image.url'),
            'url' => Request::url(),
        ]);

        return $schema
            ->merge(config('seo.schema.defaults', []))
            ->merge(array_filter([
                'name' => $title,
                'description' => $description,
                'image' => $image,
                'url' => $url,
            ]))
            ->filter();
    }
}
