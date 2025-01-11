<?php

declare(strict_types=1);

namespace Elegantly\Seo\Contracts;

use Elegantly\Seo\SeoTags;

interface Taggable
{
    public function toTags(): SeoTags;
}
