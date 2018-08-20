<?php

namespace ZhihuCrawler\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class MonthlyHotExtractor extends Extractor
{
    /**
     * @param callable $fn
     * @return array
     */
    public function getList(callable $fn)
    {
        return $this->crawler->filter('.feed-item')->each(function (Crawler $node) use ($fn) {
            $title = $node->filter('.question_link')->text();

            $this->answerExtractor->setCrawler($node);
            $this->answerExtractor->setQuestionTitle(trim($title));

            return $fn($this->answerExtractor);
        });
    }
}
