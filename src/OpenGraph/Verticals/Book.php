<?php

declare(strict_types=1);

namespace Elegantly\Seo\OpenGraph\Verticals;

use Carbon\Carbon;

/**
 * @see https://ogp.me/
 */
class Book extends Vertical
{
    public function getType(): string
    {
        return 'book';
    }

    /**
     * @param  null|(string|Profile)[]  $author
     * @param  null|string[]  $tag
     */
    public function __construct(
        public ?array $author = null,
        public ?string $isbn = null,
        public ?Carbon $release_date = null,
        public ?array $tag = null,
    ) {
        //
    }
}
