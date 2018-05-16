<?php

namespace pithyone\zhihu\crawler\Model;

use Goutte\Client;
use pithyone\zhihu\crawler\Extractors\Explore\Answers;

class Explore
{
    /**
     * @param int $offset
     *
     * @return array
     */
    static public function get($offset = 0)
    {
        $client = new Client();

        $crawler = $client->request('GET',
            'https://www.zhihu.com/node/ExploreAnswerListV2?params='.urlencode('{"offset":'.$offset.',"type":"month"}'));

        return ['answers' => Answers::extract($crawler)];
    }
}
