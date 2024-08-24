<?php

namespace Elegantly\Seo\OpenGraph\Verticals;

/**
 * @see https://ogp.me/
 */
class Profile extends Vertical
{
    public function getType(): string
    {
        return 'profile';
    }

    /**
     * @param  null|'male'|'female'  $gender
     */
    public function __construct(
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $username = null,
        public ?string $gender = null,
    ) {
        //
    }
}
