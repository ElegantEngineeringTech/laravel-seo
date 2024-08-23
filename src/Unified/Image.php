<?php

namespace Elegantly\Seo\Unified;

use Elegantly\Seo\OpenGraph\Image as OpenGraphImage;
use Elegantly\Seo\Twitter\Image as TwitterImage;

class Image
{
    public function __construct(
        public string $url,
        public ?string $type = null,
        public ?string $width = null,
        public ?string $height = null,
        public ?string $alt = null,
    ) {
        //
    }

    public function toTwitter(): TwitterImage
    {
        return new TwitterImage(
            url: $this->url,
            alt: $this->alt
        );
    }

    public function toOpenGraph(): OpenGraphImage
    {
        return new OpenGraphImage(
            url: $this->url,
            type: $this->type,
            width: $this->width,
            height: $this->height,
            alt: $this->alt
        );
    }
}
