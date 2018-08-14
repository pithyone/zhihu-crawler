<?php

namespace ZhihuCrawler\Model;

use ZhihuCrawler\Extractors\QuestionExtractor;
use ZhihuCrawler\Traits\ClientTrait;

class Question
{
    use ClientTrait;

    /**
     * @var QuestionExtractor
     */
    protected $questionExtractor;

    /**
     * @param QuestionExtractor $questionExtractor
     */
    public function __construct(QuestionExtractor $questionExtractor)
    {
        $this->questionExtractor = $questionExtractor;
    }

    /**
     * @param int $id
     * @return array
     */
    public function get($id)
    {
        $crawler = $this->client->request('GET', 'https://www.zhihu.com/question/' . $id);

        $this->questionExtractor->setCrawler($crawler);

        return $this->questionExtractor->toArray();
    }
}
