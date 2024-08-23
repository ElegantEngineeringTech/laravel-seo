<?php

namespace Elegantly\Seo\OpenGraph\Verticals;

use Carbon\Carbon;
use DateTime;
use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;

abstract class Vertical implements Taggable
{
    public string $type;

    public function toTags(): SeoTags
    {
        $tags = new SeoTags;

        foreach (get_object_vars($this) as $property => $content) {

            if ($content === null) {
                continue;
            } elseif ($property === 'type') {
                $tags->push(new Meta(
                    property: 'og:type',
                    content: $content
                ));
            } elseif ($content instanceof Taggable) {
                $tags->push(...$content->toTags());
            } elseif ($content instanceof Carbon) {
                $tags->push(new Meta(
                    property: "{$this->type}:{$property}",
                    content: $content->format(DateTime::ATOM)
                ));
            } elseif (is_array($content)) {
                foreach ($content as $value) {
                    $tags->push(new Meta(
                        property: "{$this->type}:{$property}",
                        content: $value
                    ));
                }
            } else {
                $tags->push(new Meta(
                    property: "{$this->type}:{$property}",
                    content: $content
                ));
            }
        }

        return $tags;
    }
}
