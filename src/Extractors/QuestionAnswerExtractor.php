<?php

namespace ZhihuCrawler\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class QuestionAnswerExtractor extends Extractor
{
    /**
     * @param callable $fn
     * @return array
     */
    public function getList(callable $fn)
    {
        return $this->crawler->filter('div[tabindex="-1"]')->each(function (Crawler $node) use ($fn) {
            $this->answerExtractor->setCrawler($node);

            return $fn($this->answerExtractor);
        });
    }
}
