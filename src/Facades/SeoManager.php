<?php

declare(strict_types=1);

namespace Elegantly\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Elegantly\Seo\SeoManager current()
 *
 * @see \Elegantly\Seo\SeoManager
 */
class SeoManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Elegantly\Seo\SeoManager::class;
    }
}
