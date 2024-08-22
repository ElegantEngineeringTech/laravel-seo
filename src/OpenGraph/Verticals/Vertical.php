<?php

namespace Elegantly\Seo\OpenGraph\Verticals;

use Carbon\Carbon;
use DateTime;
use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;

abstract class Vertical implements Taggable
{
    public function toTags(): SeoTags
    {
        $tags = new SeoTags;

        foreach (get_object_vars($this) as $property => $content) {

            if ($content instanceof Taggable) {
                $tags->push(...$content->toTags());
            } elseif ($content instanceof Carbon) {
                $tags->push(new Meta(
                    property: "og:{$property}",
                    content: $content->format(DateTime::ATOM)
                ));
            } elseif ($content !== null) {
                $tags->push(new Meta(
                    property: "og:{$property}",
                    content: $content
                ));
            }
        }

        return $tags;
    }
}
