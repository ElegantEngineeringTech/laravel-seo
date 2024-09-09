<?php

namespace Elegantly\Seo\Standard;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Link;
use Elegantly\Seo\Tags\Meta;
use Elegantly\Seo\Tags\Title;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

class StandardData implements Taggable
{
    /**
     * @param  null|string|string[]  $keywords
     * @param  null|Alternate[]  $alternates
     */
    public function __construct(
        public string $title,
        public string $canonical,
        public ?string $description = null,
        public null|string|array $keywords = null,
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
        ?string $description = null,
        null|string|array $keywords = null,
        ?string $robots = null,
        ?string $sitemap = null,
        ?array $alternates = null,
    ): self {
        return new self(
            title: $title ?? __(config('seo.defaults.title') ?? config('app.name')),
            canonical: $canonical ?? Request::url(),
            description: $description ?? __(config('seo.defaults.description')),
            keywords: $keywords ?? __(config('seo.defaults.keywords')),
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
