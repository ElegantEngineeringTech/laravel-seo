<?php

namespace Elegantly\Seo\Standard;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Link;
use Elegantly\Seo\Tags\Meta;
use Elegantly\Seo\Tags\Title;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

/**
 * @see https://developer.mozilla.org/fr/docs/Web/HTML/Element/meta/name
 */
class Standard implements Taggable
{
    /**
     * @param  null|string|string[]  $keywords
     * @param  null|Alternate[]  $alternates
     */
    public function __construct(
        public string $title,
        public string $canonical,
        public ?string $author = null,
        public ?string $description = null,
        public ?string $generator = null,
        public null|string|array $keywords = null,
        public ?string $referrer = null,
        public ?string $themeColor = null,
        public ?string $colorScheme = null,
        public ?string $robots = null,
        public ?string $sitemap = null,
        public ?array $alternates = null,
    ) {
        //
    }

    /**
     * @param  null|string|string[]  $keywords
     * @param  null|Alternate[]  $alternates
     */
    public static function default(
        ?string $title = null,
        ?string $canonical = null,
        ?string $author = null,
        ?string $description = null,
        ?string $generator = null,
        null|string|array $keywords = null,
        ?string $referrer = null,
        ?string $themeColor = null,
        ?string $colorScheme = null,
        ?string $robots = null,
        ?string $sitemap = null,
        ?array $alternates = null,
    ): self {
        return new self(
            title: $title ?? config('seo.defaults.title') ?? config('app.name'),
            canonical: $canonical ?? Request::url(),
            author: $author ?? config('seo.defaults.author'),
            description: $description ?? config('seo.defaults.description'),
            generator: $generator ?? config('seo.defaults.generator'),
            keywords: $keywords ?? config('seo.defaults.keywords'),
            referrer: $referrer ?? config('seo.defaults.referrer'),
            themeColor: $themeColor ?? config('seo.defaults.theme-color'),
            colorScheme: $colorScheme ?? config('seo.defaults.color-scheme'),
            robots: $robots ?? config('seo.defaults.robots'),
            sitemap: $sitemap ?? config('seo.defaults.sitemap'),
            alternates: $alternates,
        );
    }

    public function toTags(): SeoTags
    {
        $tags = new SeoTags([
            new Title(
                content: $this->title,
            ),
        ]);

        if ($this->description) {
            $tags->push(new Meta(
                name: 'description',
                content: $this->description,
            ));
        }

        if (! empty($this->keywords)) {
            $tags->push(new Meta(
                name: 'keywords',
                content: implode(',', Arr::wrap($this->keywords)),
            ));
        }

        if ($this->robots) {
            $tags->push(new Meta(
                name: 'robots',
                content: $this->robots,
            ));
        }

        if ($this->sitemap) {
            $tags->push(new Link(
                rel: 'sitemap',
                href: $this->sitemap,
                title: 'Sitemap',
                type: 'application/xml',
            ));
        }

        if ($this->canonical) {
            $tags->push(new Link(
                rel: 'canonical',
                href: $this->canonical,
            ));
        }

        if ($this->alternates) {
            foreach ($this->alternates as $alternate) {
                $tags->push(...$alternate->toTags());
            }
        }

        return $tags;
    }
}
