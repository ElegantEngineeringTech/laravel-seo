<?php

namespace Elegantly\Seo\Standard;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Link;
use Elegantly\Seo\Tags\Meta;
use Elegantly\Seo\Tags\Title;

class StandardData implements Taggable
{
    /**
     * @param  null|Alternate[]  $alternates
     */
    public function __construct(
        public string $title,
        public string $canonical,
        public ?string $description = null,
        public ?string $robots = null,
        public ?string $sitemap = null,
        public ?array $alternates = null,
    ) {
        //
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

        if ($this->robots) {
            $tags->push(new Meta(
                name: 'robots',
                content: $this->robots,
            ));
        }

        if ($this->canonical) {
            $tags->push(new Link(
                rel: 'canonical',
                href: $this->canonical,
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

        if ($this->alternates) {
            foreach ($this->alternates as $alternate) {
                $tags->push(...$alternate->toTags());
            }
        }

        return $tags;
    }
}
