<?php

namespace Elegantly\Seo\Schemas;

use Illuminate\Support\Facades\Request;

class WebPage extends Schema
{
    public static function default(
        ?string $title = null,
        ?string $url = null,
        ?string $description = null,
        ?string $image = null,
    ): self {
        $schema = new self([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => __(config('seo.defaults.title')),
            'description' => __(config('seo.defaults.description')),
            'image' => static::getImageFromConfig(),
            'url' => Request::url(),
        ]);

        return $schema
            ->merge(config('seo.schema.webpage', []))
            ->merge(array_filter([
                'name' => $title,
                'description' => $description,
                'image' => $image,
                'url' => $url,
            ]))
            ->filter();
    }

    public static function getImageFromConfig(): ?string
    {
        $url = config('seo.defaults.image.url') ?? config('seo.defaults.image');

        if ($url) {
            return filter_var($url, FILTER_VALIDATE_URL) ? $url : asset($url);
        }

        return null;
    }
}
