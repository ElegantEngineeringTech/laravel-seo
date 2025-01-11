<?php

declare(strict_types=1);

use Elegantly\Seo\Concerns\HasSeo;
use Elegantly\Seo\SeoManager;

if (! function_exists('seo')) {
    function seo(null|HasSeo|SeoManager $value = null): SeoManager
    {
        if ($value === null) {
            return \Elegantly\Seo\Facades\SeoManager::current();
        }

        if ($value instanceof HasSeo) {
            return \Elegantly\Seo\Facades\SeoManager::current()->apply($value);
        }

        return $value;
    }
}
