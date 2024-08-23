<?php

namespace Elegantly\Seo\OpenGraph;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\Verticals\Vertical;
use Elegantly\Seo\OpenGraph\Verticals\Website;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;

class OpenGraph implements Taggable
{
    public function __construct(
        public string $title,
        public string $url,

        public ?Image $image = null,
        public ?Audio $audio = null,
        public ?string $description = null,
        public ?string $determiner = null,
        public ?Locale $locale = null,
        public ?string $site_name = null,
        public ?Video $video = null,

        public Vertical $vertical = new Website,
    ) {
        //
    }

    public function toTags(): SeoTags
    {
        $tags = new SeoTags;

        foreach (get_object_vars($this) as $property => $content) {

            if ($content === null) {
                continue;
            } elseif ($content instanceof Taggable) {
                $tags->push(...$content->toTags());
            } else {
                $tags->push(new Meta(
                    property: "og:{$property}",
                    content: $content
                ));
            }
        }

        return $tags;
    }
}
