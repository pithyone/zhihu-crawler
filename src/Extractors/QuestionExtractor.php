<?php

namespace ZhihuCrawler\Extractors;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Traits\AnswerExtractorTrait;
use ZhihuCrawler\Traits\CrawlerTrait;

class QuestionExtractor
{
    use CrawlerTrait, AnswerExtractorTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->crawler->filter('.QuestionHeader-title')->text();
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        try {
            return $this->crawler->filter('.QuestionHeader-detail span')->text();
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * @return int
     */
    public function getAnswerCount()
    {
        return (int)$this->crawler->filter('meta[itemProp="answerCount"]')->attr('content');
    }

    /**
     * @return array
     */
    public function getAnswerList()
    {
        return $this->crawler->filter('div[tabindex="-1"]')->each(function (Crawler $node) {
            $this->answerExtractor->setCrawler($node);

            return array_merge([
                'image_list' => $this->answerExtractor->getImageList()
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
            'detail' => $this->getDetail(),
            'answer_count' => $this->getAnswerCount()
        ];
    }
}
