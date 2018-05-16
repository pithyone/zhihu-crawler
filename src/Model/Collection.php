<?php

namespace pithyone\zhihu\crawler\Model;

use Goutte\Client;
use pithyone\zhihu\crawler\Extractors\Collection\Answers;
use pithyone\zhihu\crawler\Extractors\Collection\Title;

class Collection
{
    /**
     * @param string $id
     *
     * @return array
     */
    static public function find($id)
    {
        $client = new Client();

        $crawler = $client->request('GET', 'https://www.zhihu.com/collection/'.$id);

        return ['title' => Title::extract($crawler), 'answers' => Answers::extract($crawler)];
    }
}
