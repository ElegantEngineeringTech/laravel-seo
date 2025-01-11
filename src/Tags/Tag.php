<?php

declare(strict_types=1);

namespace Elegantly\Seo\Tags;

abstract class Tag extends TagVoid
{
    public ?string $content = null;

    protected bool $escape = true;

    public function toHtml(): string
    {
        $content = $this->escape ? e($this->content, false) : $this->content;

        return "<{$this->tag} {$this->toProperties()->join(' ')}>{$content}</{$this->tag}>";
    }
}
