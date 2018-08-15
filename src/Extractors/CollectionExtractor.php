<?php

namespace ZhihuCrawler\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class CollectionExtractor extends Extractor
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->crawler->filter('#zh-fav-head-title')->text();
    }

    /**
     * @param callable $fn
     * @return array
     */
    public function getList(callable $fn)
    {
        return $this->crawler->filter('div[class="zm-item"]')->each(function (Crawler $node) use ($fn) {
            $title = $node->filter('.zm-item-title')->text();

            $this->answerExtractor->setCrawler($node);
            $this->answerExtractor->setQuestionTitle($title);

            return $fn($this->answerExtractor);
        });
    }
}
