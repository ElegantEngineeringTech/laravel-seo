<?php

namespace Elegantly\Seo\Twitter\Cards;

use Elegantly\Seo\Twitter\Image;

class SummaryLargeImage extends Card
{
    public string $card = 'summary_large_image';

    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $site = null,
        public ?Image $image = null,
    ) {
        //
    }
}
