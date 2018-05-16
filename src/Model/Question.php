<?php

namespace pithyone\zhihu\crawler\Model;

use Goutte\Client;
use pithyone\zhihu\crawler\Extractors\Question\AnswerCount;
use pithyone\zhihu\crawler\Extractors\Question\Detail;
use pithyone\zhihu\crawler\Extractors\Question\Title;

class Question
{
    /**
     * @param string $id
     *
     * @return array
     */
    static public function find($id)
    {
        $client = new Client();

        $crawler = $client->request('GET', 'https://www.zhihu.com/question/'.$id);

        return [
            'title'        => Title::extract($crawler),
            'detail'       => Detail::extract($crawler),
            'answer_count' => AnswerCount::extract($crawler),
        ];
    }
}
