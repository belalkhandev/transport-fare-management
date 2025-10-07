<?php

namespace App\Services\UrlSortener;

interface URLShortener
{
    /**
     * @return mixed
     */
    public function shorten(string $link, bool $isDummy = false): string;
}
