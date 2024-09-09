<?php

namespace Elegantly\Seo\Twitter\Cards;

use Elegantly\Seo\Twitter\Image;

class Summary extends Card
{
    public string $card = 'summary';

    /**
     * @param  ?string  $site  The twitter handle like "@X"
     */
    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $site = null,
        public ?Image $image = null,
    ) {
        //
    }

    public static function default(
        ?string $title = null,
        ?string $site = null,
        ?string $description = null,
        ?Image $image = null,
    ): self {
        return new self(
            title: $title ?? __(config('seo.twitter.title') ?? config('seo.defaults.title')),
            site: $site ?? config('seo.twitter.site'),
            description: $description ?? config('seo.defaults.description'),
            image: $image ?? static::getImageFromConfig(),
        );
    }
}
