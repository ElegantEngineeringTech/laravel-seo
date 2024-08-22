<?php

namespace Elegantly\Seo\Unified;

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
}
