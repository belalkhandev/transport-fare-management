<?php

namespace App\Services\UrlSortener;

class UrlShortenerManager implements URLShortener
{
    public function shorten(string $link, bool $isDummy = false): string
    {
        if ($isDummy) {
            info('[' . __METHOD__ . '] URL shortening service currently on dummy mode');

            return $link;
        }

        return app('url.shortener')->driver('tiny_url')->shorten($link);

    }
}
