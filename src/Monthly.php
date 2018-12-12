<?php

namespace ZhihuCrawler;

use Symfony\Component\DomCrawler\Crawler;

class Monthly extends AbstractExtractor
{
    /**
     * @param int $page
     * @return Crawler
     */
    protected function makeRequest($page)
    {
        $params = urlencode('{"offset":' . (($page - 1) * 5) . ',"type":"month"}');

        return $this->client->request('GET', 'https://www.zhihu.com/node/ExploreAnswerListV2?params=' . $params);
    }

    /**
     * @return array
     */
    protected function extractAnswerList()
    {
        return $this->crawler->filter('.feed-item')->each(function (ZhihuCrawler $node) {
            $title = $node->filter('.question_link')->text();

            return new Answer($node, $title);
        });
    }
}
