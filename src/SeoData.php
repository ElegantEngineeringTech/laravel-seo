<?php

namespace Elegantly\Seo;

use Elegantly\Seo\Schemas\Schema;
use Elegantly\Seo\Standard\Alternate;
use Elegantly\Seo\Unified\Image;
use Elegantly\Seo\Unified\SeoUnifiedData;
use Illuminate\Support\Facades\App;
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
        public ?Image $image = null,
        public ?string $robots = null,
        public ?string $sitemap = null,
        public ?array $alternates = null,
        public ?string $locale = null,
        public ?array $schemas = null,
        public ?SeoTags $customTags = null,
    ) {
        $this->title = $title ?? __(config('seo.title'));
        $this->canonical = $canonical ?? URL::current();
        $this->description = $description ?? __(config('seo.description'));
        $this->robots = $robots ?? config('seo.robots');
        $this->sitemap = $sitemap ?? config('seo.sitemap');
        $this->image = $image ?? $this->getImageFromConfig();
        $this->locale = $locale ?? App::getLocale();
    }

    public function getImageFromConfig(): ?Image
    {
        if ($image = config('seo.image')) {
            return new Image(
                url: filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image)
            );
        }

        return null;
    }
}
