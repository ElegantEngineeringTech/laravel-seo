<?php

namespace Elegantly\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Elegantly\Seo\Seo
 */
class Seo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Elegantly\Seo\Seo::class;
    }
}
