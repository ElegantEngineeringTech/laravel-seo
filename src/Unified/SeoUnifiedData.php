<?php

namespace Elegantly\Seo\Unified;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\Locale;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\SeoManager;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Standard\StandardData;
use Elegantly\Seo\Twitter\Cards\Card;
use Elegantly\Seo\Twitter\Cards\Summary;

class SeoUnifiedData implements Taggable
{
    /**
     * @param  null|Alternate[]  $alternates
     * @param  null|Schema[]  $schemas
     */
    public function __construct(
        public string $title,
        public string $canonical,
        public ?string $description = null,
        public ?Image $image = null,
        public ?string $robots = null,
        public ?string $sitemap = null,
        public ?array $alternates = null,
        public ?string $locale = null,
        public ?array $schemas = null,
        public ?SeoTags $customTags = null,
    ) {
        //
    }

    public function toTwitter(): Card
    {
        return new Summary(
            title: $this->title,
            description: $this->description,
            image: $this->image?->toTwitter(),
        );
    }

    public function toOpenGraph(): OpenGraph
    {
        return new OpenGraph(
            title: $this->title,
            description: $this->description,
            image: $this->image?->toOpenGraph(),
            url: $this->canonical,
            locale: $this->locale ? new Locale(
                locale: $this->locale,
                alternate: array_map(fn (Alternate $alternate) => $alternate->hreflang, $this->alternates ?? []),
            ) : null,
        );
    }

    public function toStandard(): StandardData
    {
        return new StandardData(
            title: $this->title,
            canonical: $this->canonical,
            description: $this->description,
            robots: $this->robots,
            sitemap: $this->sitemap,
            alternates: $this->alternates,
        );
    }

    public function toManager(): SeoManager
    {
        return new SeoManager(
            standard: $this->toStandard(),
            opengraph: $this->toOpenGraph(),
            twitter: $this->toTwitter(),
            schemas: $this->schemas,
            customTags: $this->customTags,
        );
    }

    public function toTags(): SeoTags
    {
        return $this->toManager()->toTags();
    }
}
