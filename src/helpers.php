<?php

use Elegantly\Seo\Concerns\HasSeo;
use Elegantly\Seo\SeoManager;

if (! function_exists('seo')) {
    function seo(null|HasSeo|SeoManager $value = null): SeoManager
    {
        if ($value === null) {
            return \Elegantly\Seo\Facades\SeoManager::current();
        }

        return SeoManager::make($value);
    }
}
