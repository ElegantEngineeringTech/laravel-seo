<?php

namespace Elegantly\Seo\Standard;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Link;

/**
 * @see https://developers.google.com/search/docs/specialty/international/localized-versions?hl=fr#html
 */
class Alternate implements Taggable
{
    public function __construct(
        public string $hreflang,
        public string $href,
    ) {
        //
    }

    public function toTags(): SeoTags
    {
        return new SeoTags([
            new Link(
                rel: 'alternate',
                hreflang: $this->hreflang,
                href: $this->href,
            ),
        ]);
    }
}
