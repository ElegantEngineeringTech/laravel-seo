<?php

namespace Elegantly\Seo\Tags;

class Title extends Tag
{
    public string $tag = 'title';

    public function __construct(
        ?string $content = null
    ) {
        $this->content = $content ? trim($content) : null;
    }
}