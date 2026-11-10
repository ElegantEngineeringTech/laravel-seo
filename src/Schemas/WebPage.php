<?php

declare(strict_types=1);

namespace Elegantly\Seo\Schemas;

use Elegantly\Seo\SeoConfig;
use Elegantly\Seo\SeoImage;
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
            'name' => SeoConfig::get('defaults.title'),
            'description' => SeoConfig::get('defaults.description'),
            'image' => static::getImageFromConfig(),
            'url' => Request::url(),
        ]);

        return $schema
            ->merge(SeoConfig::get('schema.webpage') ?? [])
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
        return SeoImage::fromConfig()?->url;
    }
}
