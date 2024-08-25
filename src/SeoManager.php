<?php

namespace Elegantly\Seo;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Standard\StandardData;
use Elegantly\Seo\Twitter\Cards\Card;
use Elegantly\Seo\Twitter\Cards\Summary;
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

    public function current(): static
    {
        return $this;
    }

    /**
     * @param  null|string|string[]  $keywords
     * @param  null|Alternate[]  $alternates
     */
    public static function default(
        ?string $title = null,
        ?string $url = null,
        ?string $description = null,
        null|string|array $keywords = null,
        ?SeoImage $image = null,
        ?string $robots = null,
        ?string $sitemap = null,
        ?array $alternates = null,
    ): self {
        return new self(
            standard: StandardData::default(
                $title,
                $url,
                $description,
                $keywords,
                $robots,
                $sitemap,
                $alternates
            ),
            opengraph: OpenGraph::default(
                title: $title,
                url: $url,
                image: $image?->toOpenGraph(),
            ),
            twitter: Summary::default(
                title: $title,
                description: $description,
                image: $image?->toTwitter(),
            ),
            schemas: [Schema::default(
                title: $title,
                url: $url,
                description: $description,
                image: $image?->secure_url ?? $image?->url,
            )],
        );
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
