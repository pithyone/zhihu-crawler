<?php

namespace pithyone\zhihu\crawler\Extractors;

use Symfony\Component\DomCrawler\Crawler;

interface Extractor
{
    /**
     * @param Crawler $crawler
     *
     * @return mixed
     */
    static public function extract($crawler);
}
