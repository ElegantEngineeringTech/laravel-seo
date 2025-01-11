<?php

declare(strict_types=1);

namespace Elegantly\Seo\OpenGraph\Verticals;

/**
 * @see https://ogp.me/
 */
class Website extends Vertical
{
    public function getType(): string
    {
        return 'website';
    }

    public function __construct()
    {
        //
    }
}
