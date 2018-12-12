<?php

namespace ZhihuCrawler;

use Symfony\Component\DomCrawler\Crawler;

class Question extends AbstractExtractor
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     * @throws NotFoundException
     */
    public function __construct($id)
    {
        $this->id = $id;

        parent::__construct();
    }

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
        return $this->crawler->filter('.QuestionHeader-detail span')->text();
    }

    /**
     * @return int
     */
    public function getAnswerCount()
    {
        return (int)$this->crawler->filter('meta[itemProp="answerCount"]')->attr('content');
    }

    /**
     * @param int $page
     * @return \Generator
     */
    public function getAnswerList($page = 1)
    {
        $response = $this->client->getClient()->post('https://www.zhihu.com/node/QuestionAnswerListV2', [
            'form_params' => [
                'method' => 'next',
                'params' => json_encode(['url_token' => $this->id, 'pagesize' => 10, 'offset' => ($page - 1) * 10]),
            ]
        ]);

        $array = json_decode((string)$response->getBody(), true);

        $title = $this->getTitle();

        foreach ($array['msg'] as $html) {
            yield $this->createAnswer($html, $title);
        }
    }

    /**
     * @param int $page
     * @return Crawler
     */
    protected function makeRequest($page)
    {
        return $this->client->request('GET', 'https://www.zhihu.com/question/' . $this->id);
    }

    /**
     * @return array
     */
    protected function extractAnswerList()
    {
        return [];
    }

    /**
     * @param string $html
     * @param string $title
     * @return Answer
     */
    protected function createAnswer($html, $title)
    {
        return new Answer(new ZhihuCrawler($html), $title);
    }
}
