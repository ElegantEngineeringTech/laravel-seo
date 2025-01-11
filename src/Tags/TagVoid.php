<?php

declare(strict_types=1);

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
     * @return Collection<string, non-falsy-string>
     */
    public function toProperties(): Collection
    {
        if (! $this->properties) {
            return new Collection;
        }

        return $this->properties
            ->map(function (string $value, string $property) {
                $value = e(trim($value));

                return "{$property}=\"{$value}\"";
            });
    }

    public function toHtml(): string
    {
        return "<{$this->tag} {$this->toProperties()->join(' ')} />";
    }
}
