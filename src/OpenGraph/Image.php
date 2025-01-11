<?php

declare(strict_types=1);

namespace Elegantly\Seo\OpenGraph;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;

class Image implements Taggable
{
    public function __construct(
        public string $url,
        public ?string $secure_url = null,
        public ?string $type = null,
        public ?string $width = null,
        public ?string $height = null,
        public ?string $alt = null,
    ) {
        //
    }

    public function toTags(): SeoTags
    {
        $tags = new SeoTags([
            new Meta(
                property: 'og:image',
                content: $this->url,
            ),
        ]);

        foreach (get_object_vars($this) as $property => $content) {
            if ($content !== null) {
                $tags->push(new Meta(
                    property: "og:image:{$property}",
                    content: $content,
                ));
            }
        }

        return $tags;
    }
}
