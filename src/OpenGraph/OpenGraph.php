<?php

declare(strict_types=1);

namespace Elegantly\Seo\OpenGraph;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\Verticals\Vertical;
use Elegantly\Seo\OpenGraph\Verticals\Website;
use Elegantly\Seo\SeoConfig;
use Elegantly\Seo\SeoImage;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\SeoVideo;
use Elegantly\Seo\Tags\Meta;
use Elegantly\Seo\Traits\DeepClone;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class OpenGraph implements Taggable
{
    use DeepClone;

    public function __construct(
        public string $title,
        public string $url,

        public ?Image $image = null,
        public ?Audio $audio = null,
        public ?string $description = null,
        public ?string $determiner = null,
        public ?Locale $locale = null,
        public ?string $site_name = null,
        public ?Video $video = null,

        public ?Vertical $vertical = null,
    ) {
        //
    }

    public static function default(
        ?string $title = null,
        ?string $url = null,
        ?Image $image = null,
        ?Audio $audio = null,
        ?string $description = null,
        ?string $determiner = null,
        ?Locale $locale = null,
        ?string $site_name = null,
        ?Video $video = null,

        ?Vertical $vertical = new Website,
    ): self {
        return new self(
            title: $title ?? SeoConfig::get('opengraph.title') ?? SeoConfig::get('defaults.title'),
            url: $url ?? Request::url(),
            image: $image ?? static::getImageFromConfig(),
            audio: $audio,
            description: $description ?? SeoConfig::get('opengraph.description') ?? SeoConfig::get('defaults.description'),
            determiner: $determiner ?? SeoConfig::get('opengraph.determiner'),
            locale: $locale ?? new Locale(App::getLocale()),
            site_name: $site_name ?? SeoConfig::get('opengraph.site_name') ?? config('app.name'),
            video: $video ?? static::getVideoFromConfig(),
            vertical: $vertical,
        );
    }

    public static function getImageFromConfig(): ?Image
    {
        return SeoImage::fromConfig('opengraph')?->toOpenGraph();
    }

    public static function getVideoFromConfig(): ?Video
    {
        return SeoVideo::fromConfig('opengraph')?->toOpenGraph();
    }

    public function toTags(): SeoTags
    {
        $tags = new SeoTags;

        foreach (get_object_vars($this) as $property => $content) {

            if ($content instanceof Taggable) {
                $tags->push(...$content->toTags());
            } elseif (! blank($content)) {
                $tags->push(new Meta(
                    property: "og:{$property}",
                    content: $content
                ));
            }
        }

        return $tags;
    }
}
