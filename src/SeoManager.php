<?php

namespace Elegantly\Seo;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\Verticals\Vertical;
use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\Standard\StandardData;
use Elegantly\Seo\Twitter\Cards\Card;

class SeoManager implements Taggable
{
    /**
     * @param  null|Schema[]  $schemas
     */
    public function __construct(
        public ?StandardData $standard = null,
        public ?Vertical $opengraph = null,
        public ?Card $twitter = null,
        public ?array $schemas = null,
        public ?SeoTags $customTags = null,
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
        if ($this->schemas) {
            foreach ($this->schemas as $schema) {
                $tags->push(...$schema->toTags());
            }
        }
        if ($this->customTags) {
            $tags->push(...$this->customTags);
        }

        return $tags;
    }
}
