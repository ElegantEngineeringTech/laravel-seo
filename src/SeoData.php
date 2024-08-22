<?php

namespace Elegantly\Seo;

use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Unified\Image;
use Elegantly\Seo\Unified\SeoUnifiedData;
use Illuminate\Support\Facades\URL;

class SeoData extends SeoUnifiedData
{
    public string $title;

    public string $canonical;

    /**
     * @param  null|Alternate[]  $alternates
     * @param  null|Schema[]  $schemas
     */
    public function __construct(
        ?string $title = null,
        ?string $canonical = null,
        public ?string $description = null,
        public ?string $robots = null,
        public ?string $sitemap = null,
        public ?array $alternates = null,
        public ?Image $image = null,
        public ?string $locale = null,
        public ?array $schemas = null,
        public ?SeoTags $customTags = null,
    ) {
        $this->title = $title ?? config('seo.title') ?? '';
        $this->canonical = $canonical ?? URL::current();
    }
}
