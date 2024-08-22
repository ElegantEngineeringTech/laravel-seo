<?php

namespace Elegantly\Seo;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\Verticals\Vertical;
use Elegantly\Seo\Standard\StandardData;
use Elegantly\Seo\Twitter\Cards\Card;

class SeoManager implements Taggable
{
    public function __construct(
        public ?StandardData $standard = null,
        public ?Vertical $opengraph = null,
        public ?Card $twitter = null,
    ) {}

    public function toTags(): SeoTags
    {
        $tags = new SeoTags;

        if ($this->standard) {
            $tags->push(...$this->standard->toTags());
        }
        if ($this->opengraph) {
            $tags->push(...$this->opengraph->toTags());
        }
        if ($this->twitter) {
            $tags->push(...$this->twitter->toTags());
        }

        return $tags;
    }
}
