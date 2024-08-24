<?php

use Elegantly\Seo\Concerns\HasSeo;
use Elegantly\Seo\SeoManager;
use Elegantly\Seo\Unified\SeoUnifiedData;

if (! function_exists('seo')) {
    function seo(null|SeoUnifiedData|SeoManager|HasSeo $value = null): SeoManager
    {
        return \Elegantly\Seo\Facades\SeoManager::make($value);
    }
}
