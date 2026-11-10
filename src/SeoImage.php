<?php

declare(strict_types=1);

namespace Elegantly\Seo;

use Elegantly\Seo\OpenGraph\Image;
use Elegantly\Seo\Twitter\Image as TwitterImage;

class SeoImage
{
    public function __construct(
        public string $url,
        public ?string $secure_url = null,
        public ?string $type = null,
        public ?string $width = null,
        public ?string $height = null,
        public ?string $alt = null,
    ) {}

    public static function fromConfig(?string $scope = null): ?self
    {
        $image = array_merge(
            SeoConfig::get('defaults.image') ?? [],
            $scope ? (SeoConfig::get("{$scope}.image") ?? []) : [],
        );

        $url = $image['url'] ?: null;

        if (! $url) {
            return null;
        }

        return new self(
            url: filter_var($url, FILTER_VALIDATE_URL) ? $url : asset($url),
            type: $image['type'] ?: null,
            width: $image['width'] ?: null,
            height: $image['height'] ?: null,
            alt: $image['alt'] ?: null,
        );
    }

    public function toOpenGraph(): Image
    {
        return new Image(
            url: $this->url,
            secure_url: $this->secure_url,
            type: $this->type,
            width: $this->width,
            height: $this->height,
            alt: $this->alt,
        );
    }

    public function toTwitter(): TwitterImage
    {
        return new TwitterImage(
            url: $this->secure_url ?? $this->url,
            alt: $this->alt
        );
    }
}
