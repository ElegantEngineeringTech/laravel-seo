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
