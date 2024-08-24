<?php

namespace Elegantly\Seo;

use Elegantly\Seo\Concerns\HasSeo;
use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\Standard\StandardData;
use Elegantly\Seo\Twitter\Cards\Card;
use Elegantly\Seo\Twitter\Cards\Summary;
use Elegantly\Seo\Unified\SeoUnifiedData;
use Illuminate\Contracts\Support\Htmlable;
use Stringable;

class SeoManager implements Htmlable, Stringable, Taggable
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

    public static function default(): self
    {
        return new self(
            standard: StandardData::default(),
            opengraph: OpenGraph::default(),
            twitter: Summary::default(),
            schemas: [Schema::default()],
        );
    }

    public static function make(
        null|SeoUnifiedData|SeoManager|HasSeo|Taggable|SeoTags $value = null
    ): SeoManager {

        if ($value instanceof SeoManager) {
            return $value;
        }

        if ($value instanceof SeoUnifiedData) {
            return $value->toManager();
        }

        if ($value instanceof HasSeo) {
            return self::make($value->getSeo());
        }

        if ($value instanceof SeoTags) {
            return new self(
                customTags: $value
            );
        }

        if ($value instanceof Taggable) {
            return self::make($value->toTags());
        }

        return self::make(self::default());
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

    public function toHtml(): string
    {
        return $this->toTags()->toHtml();
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }
}
