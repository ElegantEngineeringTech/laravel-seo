<?php

namespace Elegantly\Seo\Twitter\Cards;

use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;

abstract class Card implements Taggable
{
    public function toTags(): SeoTags
    {
        $tags = new SeoTags;

        foreach (get_object_vars($this) as $property => $content) {

            if ($content instanceof Taggable) {
                $tags->push(...$content->toTags());
            } elseif ($content !== null) {
                $tags->push(new Meta(
                    name: "twitter:{$property}",
                    content: $content
                ));
            }
        }

        return $tags;
    }
}
