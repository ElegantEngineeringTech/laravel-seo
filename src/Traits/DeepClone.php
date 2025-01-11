<?php

declare(strict_types=1);

namespace Elegantly\Seo\Traits;

trait DeepClone
{
    public function __clone()
    {
        foreach (get_object_vars($this) as $property => $value) {
            if (is_object($value)) {
                $this->{$property} = clone $value;
            }

            if (is_array($value)) {
                $this->{$property} = array_map(function ($item) {
                    if (is_object($item)) {
                        return clone $item;
                    }

                    return $item;
                }, $value);
            }
        }
    }
}
