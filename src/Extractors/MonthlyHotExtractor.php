<?php

namespace ZhihuCrawler\Extractors;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Traits\AnswerExtractorTrait;
use ZhihuCrawler\Traits\CrawlerTrait;

class MonthlyHotExtractor
{
    use CrawlerTrait, AnswerExtractorTrait;

    /**
     * @return array
     */
    public function getList()
    {
        return $this->crawler->filter('.feed-item')->each(function (Crawler $node) {
            $this->answerExtractor->setCrawler($node);

            return array_merge([
                'title' => $node->filter('.question_link')->text()
            ], $this->answerExtractor->toArray());
        });
    }
}
