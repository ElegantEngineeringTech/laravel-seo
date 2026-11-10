<?php

declare(strict_types=1);

namespace Elegantly\Seo\Twitter\Cards;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoImage;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;
use Elegantly\Seo\Traits\DeepClone;
use Elegantly\Seo\Twitter\Image;

abstract class Card implements Taggable
{
    use DeepClone;

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
        return SeoImage::fromConfig('twitter')?->toTwitter();
    }
}
