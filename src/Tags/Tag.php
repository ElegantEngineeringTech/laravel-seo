<?php

namespace Elegantly\Seo\Tags;

abstract class Tag extends TagVoid
{
    public ?string $content = null;

    public function toHtml(): string
    {
        return "<{$this->tag} {$this->toProperties()->join(' ')}>{$this->content}</{$this->tag}>";
    }
}
