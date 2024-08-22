<?php

namespace Elegantly\Seo\Twitter\Cards;

use Elegantly\Seo\Twitter\Image;

class Summary extends Card
{
    public string $card = 'summary';

    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $site = null,
        public ?Image $image = null,
    ) {
        //
    }
}
