<?php

namespace Elegantly\Seo\OpenGraph\Verticals;

use Elegantly\Seo\OpenGraph\Audio;
use Elegantly\Seo\OpenGraph\Image;
use Elegantly\Seo\OpenGraph\Locale;
use Elegantly\Seo\OpenGraph\Video;

/**
 * @see https://ogp.me/
 */
class Website extends Vertical
{
    public string $type = 'website';

    public function __construct(
        public string $title,
        public string $url,

        public ?Image $image = null,
        public ?Audio $audio = null,
        public ?string $description = null,
        public ?string $determiner = null,
        public ?Locale $locale = null,
        public ?string $site_name = null,
        public ?Video $video = null,
    ) {
        //
    }
}
