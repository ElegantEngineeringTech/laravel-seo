<?php

namespace Elegantly\Seo\Contracts;

use Elegantly\Seo\SeoData;
use Elegantly\Seo\SeoManager;
use Elegantly\Seo\Unified\SeoUnifiedData;

interface HasSeo
{
    public function getSeoData(): SeoManager|SeoData|SeoUnifiedData;
}
