<?php

declare(strict_types=1);

namespace Elegantly\Seo\Twitter\Cards;

use Elegantly\Seo\SeoConfig;
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
            title: $title ?? SeoConfig::get('twitter.title') ?? SeoConfig::get('defaults.title'),
            site: $site ?? SeoConfig::get('twitter.site'),
            description: $description ?? SeoConfig::get('defaults.description'),
            image: $image ?? static::getImageFromConfig(),
        );
    }
}
