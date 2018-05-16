<?php

namespace pithyone\zhihu\crawler\Model;

use GuzzleHttp\Client;
use pithyone\zhihu\crawler\Extractors\Answer\Answers;
use Symfony\Component\DomCrawler\Crawler;

class Answer
{
    /**
     * @param string $id
     * @param int    $offset
     *
     * @return array
     */
    static public function get($id, $offset = 0)
    {
        $client = new Client();

        $response = $client->post('https://www.zhihu.com/node/QuestionAnswerListV2', [
            'form_params' => [
                'method' => 'next',
                'params' => json_encode(['url_token' => $id, 'pagesize' => 10, 'offset' => $offset]),
            ],
        ]);

        $data = \GuzzleHttp\json_decode((string) $response->getBody(), true);

        if (!isset($data['msg']) || !is_array($data['msg'])) {
            throw new \InvalidArgumentException('response mag should be array');
        }

        $html = implode('', $data['msg']);

        $crawler = new Crawler($html);

        return ['answers' => Answers::extract($crawler)];
    }
}
