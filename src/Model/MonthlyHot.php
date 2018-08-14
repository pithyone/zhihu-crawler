<?php

namespace ZhihuCrawler\Model;

use ZhihuCrawler\Extractors\MonthlyHotExtractor;
use ZhihuCrawler\Traits\ClientTrait;

class MonthlyHot
{
    use ClientTrait;

    /**
     * @var MonthlyHotExtractor
     */
    protected $monthlyHotExtractor;

    /**
     * @param MonthlyHotExtractor $monthlyHotExtractor
     */
    public function __construct(MonthlyHotExtractor $monthlyHotExtractor)
    {
        $this->monthlyHotExtractor = $monthlyHotExtractor;
    }

    /**
     * @return array
     */
    public function getList()
    {
        $crawler = $this->client->request('GET', 'https://www.zhihu.com/node/ExploreAnswerListV2?params=' . urlencode('{"offset":0,"type":"month"}'));

        $this->monthlyHotExtractor->setCrawler($crawler);

        return $this->monthlyHotExtractor->getList();
    }
}
