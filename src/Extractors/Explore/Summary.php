<?php

namespace pithyone\zhihu\crawler\Extractors\Explore;

use pithyone\zhihu\crawler\Extractors\Extractor;

class Summary implements Extractor
{
    static public function extract($crawler)
    {
        $summary = $crawler->filter('.zh-summary')->text();

        return trim(str_replace('显示全部', '', $summary));
    }
}
