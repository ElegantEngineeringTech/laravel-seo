<?php

declare(strict_types=1);

namespace Elegantly\Seo;

use Elegantly\Seo\OpenGraph\Video;

/**
 * A video shown in link previews, next to the image.
 *
 * iMessage plays it inline when the url points to a playable file, like an MPEG-4,
 * rather than to a page that embeds the video.
 *
 * @see https://developer.apple.com/documentation/technotes/tn3156-create-rich-previews-for-messages
 */
class SeoVideo
{
    public function __construct(
        public string $url,
        public ?string $secure_url = null,
        public ?string $type = null,
        public ?string $width = null,
        public ?string $height = null,
    ) {}

    public static function fromConfig(?string $scope = null): ?self
    {
        /** @var null|array{url?: string, secure_url?: string, type?: string, width?: string, height?: string} $video */
        $video = array_merge(
            SeoConfig::get('defaults.video') ?? [],
            $scope ? (SeoConfig::get("{$scope}.video") ?? []) : [],
        );

        $url = $video['url'] ?? null;

        if (! $url) {
            return null;
        }

        return new self(
            url: filter_var($url, FILTER_VALIDATE_URL) ? $url : asset($url),
            secure_url: $video['secure_url'] ?? null,
            type: $video['type'] ?? null,
            width: $video['width'] ?? null,
            height: $video['height'] ?? null,
        );
    }

    public function toOpenGraph(): Video
    {
        return new Video(
            url: $this->url,
            secure_url: $this->secure_url,
            type: $this->type,
            width: $this->width,
            height: $this->height,
        );
    }
}
