<?php

namespace ZhihuCrawler\Extractors;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Traits\AnswerExtractorTrait;
use ZhihuCrawler\Traits\CrawlerTrait;

class CollectionExtractor
{
    use CrawlerTrait, AnswerExtractorTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->crawler->filter('#zh-fav-head-title')->text();
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->crawler->filter('div[class="zm-item"]')->each(function (Crawler $node) {
            $this->answerExtractor->setCrawler($node);

            return array_merge([
                'title' => $node->filter('.zm-item-title')->text()
            ], $this->answerExtractor->toArray());
        });
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'title' => $this->getTitle(),
            'list' => $this->getList()
        ];
    }
}
