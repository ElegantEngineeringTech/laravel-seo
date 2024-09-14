<?php

namespace Elegantly\Seo;

use Closure;
use Elegantly\Seo\Concerns\HasSeo;
use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\Locale;
use Elegantly\Seo\OpenGraph\OpenGraph;
use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\Schemas\WebPage;
use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Standard\Standard;
use Elegantly\Seo\Traits\DeepClone;
use Elegantly\Seo\Twitter\Cards\Card;
use Elegantly\Seo\Twitter\Cards\Summary;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Conditionable;
use Stringable;

class SeoManager implements Htmlable, Stringable, Taggable
{
    use Conditionable;
    use DeepClone;

    /**
     * @param  null|Schema[]  $schemas
     */
    public function __construct(
        public ?Standard $standard = null,
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

    public function apply(HasSeo $class): self
    {
        return $class->applySeo($this);
    }

    /**
     * @return $this
     */
    public function set(SeoManager $manager): static
    {
        return $this
            ->setStandard($manager->standard)
            ->setOpengraph($manager->opengraph)
            ->setTwitter($manager->twitter)
            ->setWebpage($manager->webpage)
            ->setSchemas($manager->schemas)
            ->setCustomTags($manager->customTags);
    }

    /**
     * @param  null|Standard|(Closure(Standard):(null|Standard))  $value
     * @return $this
     */
    public function setStandard(null|Standard|Closure $value): static
    {
        if ($value instanceof Closure) {
            $this->standard = $value($this->standard ?? Standard::default());
        } else {
            $this->standard = $value;
        }

        return $this;
    }

    /**
     * @param  null|OpenGraph|(Closure(OpenGraph):(null|OpenGraph))  $value
     * @return $this
     */
    public function setOpengraph(null|OpenGraph|Closure $value): static
    {
        if ($value instanceof Closure) {
            $this->opengraph = $value($this->opengraph ?? OpenGraph::default());
        } else {
            $this->opengraph = $value;
        }

        return $this;
    }

    /**
     * @param  null|Card|(Closure(Card):(null|Card))  $value
     * @return $this
     */
    public function setTwitter(null|Card|Closure $value): static
    {
        if ($value instanceof Closure) {
            $this->twitter = $value($this->twitter ?? Summary::default());
        } else {
            $this->twitter = $value;
        }

        return $this;
    }

    /**
     * @param  null|WebPage|(Closure(WebPage):(null|WebPage))  $value
     * @return $this
     */
    public function setWebpage(null|WebPage|Closure $value): static
    {
        if ($value instanceof Closure) {
            $this->webpage = $value($this->webpage ?? WebPage::default());
        } else {
            $this->webpage = $value;
        }

        return $this;
    }

    /**
     * @param  null|Schema[]|(Closure(Schema[]):(null|Schema[]))  $value
     * @return $this
     */
    public function setSchemas(null|array|Closure $value): static
    {
        if ($value instanceof Closure) {
            $this->schemas = $value($this->schemas ?? []);
        } else {
            $this->schemas = $value;
        }

        return $this;
    }

    /**
     * @param  null|SeoTags|(Closure(SeoTags):(null|SeoTags))  $value
     * @return $this
     */
    public function setCustomTags(null|SeoTags|Closure $value): static
    {
        if ($value instanceof Closure) {
            $this->customTags = $value($this->customTags ?? new SeoTags);
        } else {
            $this->customTags = $value;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function addSchema(Schema $value): static
    {
        return $this->setSchemas(function ($schemas) use ($value) {
            $schemas[] = $value;

            return $schemas;
        });
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
                alternate: collect($value)
                    ->where('hreflang', '!=', 'x-default')
                    ->map(fn ($item) => $item->toOpenGraph())
                    ->toArray()
            );
        }

        return $this;
    }

    /**
     * @param  null|string|string[]  $value
     * @return $this
     */
    public function setKeywords(null|string|array $value): static
    {
        if ($this->standard) {
            $this->standard->keywords = $value;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setAuthor(?string $value): static
    {
        if ($this->standard) {
            $this->standard->author = $value;
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
            standard: Standard::default(
                title: $title,
                canonical: $url,
                description: $description,
                keywords: $keywords,
                robots: $robots,
                sitemap: $sitemap,
                alternates: $alternates
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
