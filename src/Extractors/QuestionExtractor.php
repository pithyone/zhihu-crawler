<?php

namespace ZhihuCrawler\Extractors;

class QuestionExtractor extends Extractor
{
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
}
