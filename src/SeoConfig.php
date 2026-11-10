<?php

declare(strict_types=1);

namespace Elegantly\Seo;

use Illuminate\Support\Facades\App;

/**
 * Reads values from the "seo" config file.
 *
 * A value can be computed at runtime with a [class, method] pair, like `[SeoDefaults::class, 'title']`.
 * The method is called through the container, so its dependencies are injected.
 */
class SeoConfig
{
    /**
     * @param  string  $key  A dot-notation key relative to the "seo" config, like "defaults.title"
     */
    public static function get(string $key): mixed
    {
        $value = config("seo.{$key}");

        if (
            is_array($value) &&
            array_is_list($value) &&
            count($value) === 2 &&
            is_string($value[0]) &&
            is_string($value[1]) &&
            class_exists($value[0]) &&
            method_exists($value[0], $value[1])
        ) {
            return App::call("{$value[0]}@{$value[1]}");
        }

        return $value;
    }
}
