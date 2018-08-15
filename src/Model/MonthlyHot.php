<?php

namespace ZhihuCrawler\Model;

use Goutte\Client;
use ZhihuCrawler\Extractors\MonthlyHotExtractor;

class MonthlyHot
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var MonthlyHotExtractor
     */
    protected $monthlyHotExtractor;

    /**
     * @param Client $client
     * @param MonthlyHotExtractor $monthlyHotExtractor
     */
    public function __construct(Client $client, MonthlyHotExtractor $monthlyHotExtractor)
    {
        $this->client = $client;
        $this->monthlyHotExtractor = $monthlyHotExtractor;
    }

    /**
     * @return MonthlyHotExtractor
     */
    public function extract()
    {
        $crawler = $this->client->request('GET', 'https://www.zhihu.com/node/ExploreAnswerListV2?params=' . urlencode('{"offset":0,"type":"month"}'));

        $this->monthlyHotExtractor->setCrawler($crawler);

        return $this->monthlyHotExtractor;
    }
}
