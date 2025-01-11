<?php

declare(strict_types=1);

namespace Elegantly\Seo\Standard;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Link;
use Elegantly\Seo\Tags\Meta;
use Elegantly\Seo\Tags\Title;
use Elegantly\Seo\Traits\DeepClone;
use Illuminate\Support\Facades\Request;

/**
 * @see https://developer.mozilla.org/fr/docs/Web/HTML/Element/meta/name
 */
class Standard implements Taggable
{
    use DeepClone;

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
        $tags = new SeoTags;

        $items = get_object_vars($this);

        foreach ($items as $key => $value) {
            if (blank($value)) {
                continue;
            }

            if ($key === 'title') {
                $tags->push(new Title(
                    content: $value,
                ));
            } elseif ($key === 'sitemap') {
                $tags->push(new Link(
                    rel: $key,
                    href: $value,
                    title: 'Sitemap',
                    type: 'application/xml',
                ));
            } elseif ($key === 'canonical') {
                $tags->push(new Link(
                    rel: $key,
                    href: $value,
                ));
            } elseif ($key === 'alternates') {
                /**
                 * @var Taggable[] $value
                 */
                foreach ($value as $item) {
                    $tags->push(...$item->toTags());
                }
            } else {
                $tags->push(new Meta(
                    name: $key,
                    content: is_array($value) ? implode(',', $value) : $value,
                ));
            }
        }

        return $tags;
    }
}
