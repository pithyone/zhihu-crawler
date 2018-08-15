<?php

namespace ZhihuCrawler\Model;

use Goutte\Client;
use ZhihuCrawler\Extractors\QuestionExtractor;

class Question
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var QuestionExtractor
     */
    protected $questionExtractor;

    /**
     * @param Client $client
     * @param QuestionExtractor $questionExtractor
     */
    public function __construct(Client $client, QuestionExtractor $questionExtractor)
    {
        $this->client = $client;
        $this->questionExtractor = $questionExtractor;
    }

    /**
     * @param int $id
     * @return QuestionExtractor
     */
    public function extract($id)
    {
        $crawler = $this->client->request('GET', 'https://www.zhihu.com/question/' . $id);

        $this->questionExtractor->setCrawler($crawler);

        return $this->questionExtractor;
    }
}
