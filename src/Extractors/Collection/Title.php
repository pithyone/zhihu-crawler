<?php

namespace pithyone\zhihu\crawler\Extractors\Collection;

use pithyone\zhihu\crawler\Extractors\Extractor;

class Title implements Extractor
{
    static public function extract($crawler)
    {
        $title = $crawler->filter('#zh-fav-head-title')->text();

        return trim($title);
    }
}
