<?php

namespace ZhihuCrawler\Traits;

use Symfony\Component\DomCrawler\Crawler;

trait CrawlerTrait
{
    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @param Crawler $crawler
     */
    public function setCrawler($crawler)
    {
        $this->crawler = $crawler;
    }
}
