<?php

namespace Elegantly\Seo;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\Locale;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\Schemas\WebPage;
use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Standard\StandardData;
use Elegantly\Seo\Twitter\Cards\Card;
use Elegantly\Seo\Twitter\Cards\Summary;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Conditionable;
use Stringable;

class SeoManager implements Htmlable, Stringable, Taggable
{
    use Conditionable;

    /**
     * @param  null|Schema[]  $schemas
     */
    public function __construct(
        public ?StandardData $standard = null,
        public ?OpenGraph $opengraph = null,
        public ?Card $twitter = null,
        public ?WebPage $webpage = null,
        public ?array $schemas = null,
        public ?SeoTags $customTags = null,
    ) {}

    /**
     * @return $this
     */
    public function current(): static
    {
        return $this;
    }

    /**
     * @return $this
     */
    public function setOpengraph(?OpenGraph $value): static
    {
        $this->opengraph = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function setTwitter(?Card $value): static
    {
        $this->twitter = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function setWebpage(?WebPage $value): static
    {
        $this->webpage = $value;

        return $this;
    }

    public function setTitle(string $value): static
    {
        if ($this->standard) {
            $this->standard->title = $value;
        }
        if ($this->opengraph) {
            $this->opengraph->title = $value;
        }
        if ($this->webpage) {
            $this->webpage->put('name', $value);
        }
        if ($this->twitter instanceof Summary) {
            $this->twitter->title = $value;
        }

        return $this;
    }

    public function setDescription(string $value): static
    {
        if ($this->standard) {
            $this->standard->description = $value;
        }
        if ($this->opengraph) {
            $this->opengraph->description = $value;
        }
        if ($this->webpage) {
            $this->webpage->put('description', $value);
        }
        if ($this->twitter instanceof Summary) {
            $this->twitter->description = $value;
        }

        return $this;
    }

    public function setUrl(string $value): static
    {
        if ($this->standard) {
            $this->standard->canonical = $value;
        }
        if ($this->opengraph) {
            $this->opengraph->url = $value;
        }
        if ($this->webpage) {
            $this->webpage->put('url', $value);
        }

        return $this;
    }

    public function setImage(SeoImage|string $value): static
    {
        $value = $value instanceof SeoImage ? $value : new SeoImage($value);

        if ($this->opengraph) {
            $this->opengraph->image = $value->toOpenGraph();
        }
        if ($this->twitter instanceof Summary) {
            $this->twitter->image = $value->toTwitter();
        }
        if ($this->webpage) {
            $this->webpage->put('image', $value->secure_url ?? $value->url);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setRobots(?string $value): static
    {
        if ($this->standard) {
            $this->standard->robots = $value;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setSitmap(?string $value): static
    {
        if ($this->standard) {
            $this->standard->sitemap = $value;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setLocale(
        string $value,
    ): static {
        if ($this->opengraph) {
            $this->opengraph->locale = new Locale(
                locale: $value,
                alternate: $this->opengraph->locale?->alternate ?? [],
            );
        }

        return $this;
    }

    /**
     * @param  null|Alternate[]  $value
     * @return $this
     */
    public function setAlternates(?array $value): static
    {
        if ($this->standard) {
            $this->standard->alternates = $value;
        }

        if ($this->opengraph) {
            $this->opengraph->locale = new Locale(
                locale: $this->opengraph->locale?->locale ?? App::getLocale(),
                alternate: array_map(fn ($item) => $item->toOpenGraph(), $value ?? [])
            );
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function noIndexNoFollow(): static
    {
        return $this->setRobots('noindex, nofollow');
    }

    /**
     * @return $this
     */
    public function noIndex(): static
    {
        return $this->setRobots('noindex');
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
                description: $description,
                image: $image?->toOpenGraph(),
            ),
            twitter: Summary::default(
                title: $title,
                description: $description,
                image: $image?->toTwitter(),
            ),
            webpage: WebPage::default(
                title: $title,
                url: $url,
                description: $description,
                image: $image?->secure_url ?? $image?->url,
            ),
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

        if ($this->webpage) {
            $tags->push(...$this->webpage->toTags());
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
