<?php

namespace Elegantly\Seo\OpenGraph;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;

class Audio implements Taggable
{
    public function __construct(
        public string $url,
        public string $type,
    ) {
        //
    }

    public function toTags(): SeoTags
    {
        $tags = new SeoTags([
            new Meta(
                property: 'og:audio',
                content: $this->url,
            ),
        ]);

        foreach (get_object_vars($this) as $property => $content) {
            $tags->push(new Meta(
                property: "og:audio:{$property}",
                content: $content,
            ));
        }

        return $tags;
    }
}
