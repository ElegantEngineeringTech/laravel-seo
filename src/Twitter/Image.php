<?php

declare(strict_types=1);

namespace Elegantly\Seo\Twitter;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;

class Image implements Taggable
{
    public function __construct(
        public string $url,
        public ?string $alt = null,
    ) {
        //
    }

    public function toTags(): SeoTags
    {
        $tags = new SeoTags([
            new Meta(
                name: 'twitter:image',
                content: $this->url,
            ),
        ]);

        if ($this->alt) {
            $tags->push(new Meta(
                name: 'twitter:image:alt',
                content: $this->alt
            ));
        }

        return $tags;
    }
}
