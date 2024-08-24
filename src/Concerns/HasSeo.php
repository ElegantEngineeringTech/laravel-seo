<?php

namespace Elegantly\Seo\Concerns;

use Elegantly\Seo\Contracts\Taggable;

interface HasSeo
{
    public function getSeo(): Taggable;
}
