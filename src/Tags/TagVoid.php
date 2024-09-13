<?php

namespace Elegantly\Seo\Tags;

use Elegantly\Seo\Traits\DeepClone;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

abstract class TagVoid implements Htmlable
{
    use DeepClone;

    public string $tag;

    /**
     * @var ?Collection<string, string>
     */
    public ?Collection $properties = null;

    /**
     * @return Collection<string, string>
     */
    public function toProperties(): Collection
    {
        return $this->properties
            ?->map(fn (?string $value) => $value ? trim($value) : null)
            ->map(fn (?string $value, string $property) => "{$property}=\"{$value}\"")
            ?? new Collection;
    }

    public function toHtml(): string
    {
        return "<{$this->tag} {$this->toProperties()->join(' ')} />";
    }
}
