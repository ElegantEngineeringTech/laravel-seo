<?php

namespace Elegantly\Seo\OpenGraph;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;

class Locale implements Taggable
{
    /**
     * @param  string[]  $alternate
     */
    public function __construct(
        public string $locale,
        public array $alternate = [],
    ) {
        //
    }

    public function toTags(): SeoTags
    {
        $tags = new SeoTags([
            new Meta(
                property: 'og:locale',
                content: $this->locale,
            ),
        ]);

        foreach ($this->alternate as $locale) {
            $tags->push(new Meta(
                property: 'og:locale:alternate',
                content: $locale
            ));
        }

        return $tags;
    }
}
