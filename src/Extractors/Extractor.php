<?php

namespace ZhihuCrawler\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class Extractor
{
    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var AnswerExtractor
     */
    protected $answerExtractor;

    /**
     * @param Crawler $crawler
     * @param AnswerExtractor $answerExtractor
     */
    public function __construct(Crawler $crawler, AnswerExtractor $answerExtractor)
    {
        $this->crawler = $crawler;
        $this->answerExtractor = $answerExtractor;
    }

    /**
     * @param Crawler $crawler
     */
    public function setCrawler($crawler)
    {
        $this->crawler = $crawler;
    }
}
