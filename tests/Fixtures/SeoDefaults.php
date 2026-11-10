<?php

declare(strict_types=1);

namespace Elegantly\Seo\Tests\Fixtures;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\App;

class SeoDefaults
{
    public function title(Application $app): string
    {
        return "Title ({$app->getLocale()})";
    }

    public function description(): string
    {
        return match (App::getLocale()) {
            'fr' => 'Description en français',
            default => 'English description',
        };
    }

    /**
     * @return array{url: string, alt: string}
     */
    public static function image(): array
    {
        return [
            'url' => 'https://example.com/opengraph.png',
            'alt' => 'Default alt',
        ];
    }

    /**
     * @return array{url: string, type: string}
     */
    public static function video(): array
    {
        return [
            'url' => 'https://example.com/opengraph.mp4',
            'type' => 'video/mp4',
        ];
    }
}
