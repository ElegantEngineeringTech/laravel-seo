<?php

namespace Elegantly\Seo;

use Elegantly\Seo\Contracts\HasSeo;
use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\Standard\StandardData;
use Elegantly\Seo\Twitter\Cards\Card;
use Elegantly\Seo\Unified\SeoUnifiedData;

class SeoManager implements Taggable
{
    /**
     * @param  null|Schema[]  $schemas
     */
    public function __construct(
        public ?StandardData $standard = null,
        public ?OpenGraph $opengraph = null,
        public ?Card $twitter = null,
        public ?array $schemas = null,
        public ?SeoTags $customTags = null,
    ) {}

    public function from(
        null|SeoData|SeoUnifiedData|SeoManager|HasSeo $value = null
    ): SeoManager {

        if ($value instanceof SeoManager) {
            return $value;
        }

        if ($value instanceof SeoData) {
            return $value->toManager();
        }

        if ($value instanceof SeoUnifiedData) {
            return $value->toManager();
        }

        if ($value instanceof HasSeo) {
            return $this->from($value->getSeoData());
        }

        return $this->from(new SeoData);
    }

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
