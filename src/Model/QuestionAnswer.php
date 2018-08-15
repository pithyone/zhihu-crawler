<?php

namespace ZhihuCrawler\Model;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Extractors\QuestionAnswerExtractor;

class QuestionAnswer
{
    const PAGE_SIZE = 10;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var QuestionAnswerExtractor
     */
    protected $questionAnswerExtractor;

    /**
     * @param Client $client
     * @param Crawler $crawler
     * @param QuestionAnswerExtractor $questionAnswerExtractor
     */
    public function __construct(Client $client, Crawler $crawler, QuestionAnswerExtractor $questionAnswerExtractor)
    {
        $this->client = $client;
        $this->crawler = $crawler;
        $this->questionAnswerExtractor = $questionAnswerExtractor;
    }

    /**
     * @param int $questionId
     * @param int $size
     * @return QuestionAnswerExtractor
     */
    public function extract($questionId, $size = self::PAGE_SIZE)
    {
        $content = '';

        for ($offset = 0; $offset < $size; $offset += self::PAGE_SIZE) {
            $content .= $this->getContent($questionId, $offset);
        }

        $this->crawler->addContent($content);

        $this->questionAnswerExtractor->setCrawler($this->crawler);

        return $this->questionAnswerExtractor;
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
