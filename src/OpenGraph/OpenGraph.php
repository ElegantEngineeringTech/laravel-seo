<?php

namespace Elegantly\Seo\OpenGraph;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\OpenGraph\Verticals\Vertical;
use Elegantly\Seo\OpenGraph\Verticals\Website;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class OpenGraph implements Taggable
{
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
            title: $title ?? __(config('seo.opengraph.title') ?? config('seo.defaults.title')),
            url: $url ?? Request::url(),
            image: $image ?? static::getImageFromConfig(),
            audio: $audio,
            description: $description ?? __(config('seo.opengraph.description') ?? config('seo.defaults.description')),
            determiner: $determiner ?? config('seo.opengraph.determiner'),
            locale: $locale ?? new Locale(App::getLocale()),
            site_name: $site_name ?? config('seo.opengraph.site_name') ?? config('app.name'),
            video: $video,
            vertical: $vertical,
        );
    }

    public static function getImageFromConfig(): ?Image
    {
        $url = config('seo.opengraph.image.url') ?? config('seo.defaults.image.url');

        if ($url) {
            return new Image(
                url: filter_var($url, FILTER_VALIDATE_URL) ? $url : asset($url),
                type: config('seo.opengraph.image.type') ?? config('seo.defaults.image.type'),
                width: config('seo.opengraph.image.width') ?? config('seo.defaults.image.width'),
                height: config('seo.opengraph.image.height') ?? config('seo.defaults.image.height'),
                alt: config('seo.opengraph.image.alt') ?? config('seo.defaults.image.alt')
            );
        }

        return null;
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
