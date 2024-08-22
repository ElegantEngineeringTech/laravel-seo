<?php

namespace Elegantly\Seo;

class SeoData
{
    public function __construct(
        public ?string $title,
        public ?string $description,
    ) {
        //
    }
}
