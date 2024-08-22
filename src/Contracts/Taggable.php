<?php

namespace Elegantly\Seo\Contracts;

use Elegantly\Seo\SeoTags;

interface Taggable
{
    public function toTags(): SeoTags;
}
