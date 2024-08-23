<?php

namespace Elegantly\Seo\OpenGraph\Verticals;

use Carbon\Carbon;

/**
 * @see https://ogp.me/
 */
class Article extends Vertical
{
    public string $type = 'article';

    /**
     * @param  null|string[]  $tag
     * @param  null|string[]  $author
     */
    public function __construct(
        public ?Carbon $published_time = null,
        public ?Carbon $modified_time = null,
        public ?Carbon $expiration_time = null,
        public ?array $author = null,
        public ?string $section = null,
        public ?array $tag = null,
    ) {
        //
    }
}
