<?php

namespace Elegantly\Seo\Twitter\Cards;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;
use Elegantly\Seo\Twitter\Image;

abstract class Card implements Taggable
{
    public function toTags(): SeoTags
    {
        $tags = new SeoTags;

        foreach (get_object_vars($this) as $property => $content) {

            if ($content instanceof Taggable) {
                $tags->push(...$content->toTags());
            } elseif (! blank($content)) {
                $tags->push(new Meta(
                    name: "twitter:{$property}",
                    content: $content
                ));
            }
        }

        return $tags;
    }

    public static function getImageFromConfig(): ?Image
    {
        $url = config('seo.twitter.image.url') ?? config('seo.defaults.image.url') ?? config('seo.defaults.image');

        if ($url) {
            return new Image(
                url: filter_var($url, FILTER_VALIDATE_URL) ? $url : asset($url),
                alt: config('seo.twitter.image.alt') ?? config('seo.defaults.image.alt')
            );
        }

        return null;
    }
}
