<?php

namespace Elegantly\Seo\OpenGraph\Verticals;

use Carbon\Carbon;
use DateTime;
use Elegantly\Seo\Contracts\Taggable;
use Elegantly\Seo\SeoTags;
use Elegantly\Seo\Tags\Meta;
use Illuminate\Support\Arr;

abstract class Vertical implements Taggable
{
    abstract public function getType(): string;

    public function getNamespace(): string
    {
        return $this->getType();
    }

    public function getTypeTag(): Meta
    {
        return new Meta(
            property: 'og:type',
            content: $this->getType(),
        );
    }

    protected function formatContent(null|string|Carbon $value): ?string
    {
        if ($value === null) {
            return $value;
        }

        if ($value instanceof Carbon) {
            return $value->format(DateTime::ATOM);
        }

        return $value;
    }

    public function toTags(?string $prefix = null): SeoTags
    {
        $tags = new SeoTags;

        if ($prefix === null) {
            $tags->push($this->getTypeTag());
            $prefix = $this->getNamespace();
        }

        $properties = get_object_vars($this);

        foreach ($properties as $property => $content) {

            if ($content === null) {
                continue;
            }

            foreach (Arr::wrap($content) as $item) {

                if ($item instanceof Vertical) {
                    $tags->push(...$item->toTags("{$prefix}:{$property}"));
                } else {
                    $tags->push(new Meta(
                        property: $prefix.':'.$property,
                        content: $this->formatContent($item)
                    ));
                }
            }
        }

        return $tags;
    }
}
