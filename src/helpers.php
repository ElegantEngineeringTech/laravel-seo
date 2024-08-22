<?php

use Elegantly\Seo\Contracts\HasSeo;
use Elegantly\Seo\SeoData;
use Elegantly\Seo\SeoManager;
use Elegantly\Seo\Unified\SeoUnifiedData;

if (! function_exists('seo')) {
    function seo(null|SeoData|SeoUnifiedData|SeoManager|HasSeo $value): SeoManager
    {
        return \Elegantly\Seo\Facades\SeoManager::from($value);
    }
}
