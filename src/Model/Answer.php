<?php

namespace ZhihuCrawler\Model;

use ZhihuCrawler\Extractors\QuestionExtractor;
use ZhihuCrawler\Traits\CrawlerTrait;
use ZhihuCrawler\Traits\GuzzleClientTrait;

class Answer
{
    use GuzzleClientTrait, CrawlerTrait;

    const PAGE_SIZE = 10;

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
     * @param int $questionId
     * @param int $size
     * @return array
     */
    public function getList($questionId, $size = self::PAGE_SIZE)
    {
        $content = '';

        for ($offset = 0; $offset < $size; $offset += self::PAGE_SIZE) {
            $content .= $this->getContent($questionId, $offset);
        }

        $this->crawler->addContent($content);

        $this->questionExtractor->setCrawler($this->crawler);

        return $this->questionExtractor->getAnswerList();
    }

    /**
     * @param int $questionId
     * @param int $offset
     * @return string
     */
    protected function getContent($questionId, $offset)
    {
        $response = $this->client->post('https://www.zhihu.com/node/QuestionAnswerListV2', [
            'form_params' => [
                'method' => 'next',
                'params' => \GuzzleHttp\json_encode(['url_token' => $questionId, 'pagesize' => self::PAGE_SIZE, 'offset' => $offset]),
            ]
        ]);

        $data = \GuzzleHttp\json_decode((string)$response->getBody(), true);

        return implode($data['msg']);
    }
}
