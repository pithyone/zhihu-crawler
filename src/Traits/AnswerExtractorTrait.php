<?php

namespace ZhihuCrawler\Traits;

use ZhihuCrawler\Extractors\AnswerExtractor;

trait AnswerExtractorTrait
{
    /**
     * @var AnswerExtractor
     */
    protected $answerExtractor;

    /**
     * @param AnswerExtractor $answerExtractor
     */
    public function setAnswerExtractor($answerExtractor)
    {
        $this->answerExtractor = $answerExtractor;
    }
}
