<?php

namespace Elegantly\Seo\Facades;

use Elegantly\Seo\Concerns\HasSeo;
use Elegantly\Seo\SeoData;
use Elegantly\Seo\Unified\SeoUnifiedData;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Elegantly\Seo\SeoManager make(null|SeoData|SeoUnifiedData|\Elegantly\Seo\SeoManager|HasSeo $value = null)
 *
 * @see \Elegantly\Seo\Seo
 */
class SeoManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Elegantly\Seo\SeoManager::class;
    }
}
