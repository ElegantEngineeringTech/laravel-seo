<?php

declare(strict_types=1);

namespace Elegantly\Seo\Concerns;

use Elegantly\Seo\SeoManager;

interface HasSeo
{
    public function applySeo(SeoManager $manager): SeoManager;
}
