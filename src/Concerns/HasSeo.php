<?php

namespace Elegantly\Seo\Concerns;

use Elegantly\Seo\SeoManager;

interface HasSeo
{
    public function getSeo(): SeoManager;
}
