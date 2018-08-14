<?php

namespace ZhihuCrawler\Tests\Model;

use Goutte\Client;
use ZhihuCrawler\Extractors\MonthlyHotExtractor;
use ZhihuCrawler\Model\MonthlyHot;
use ZhihuCrawler\Tests\TestCase;

class MonthlyHotTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetList()
    {
        $client = \Mockery::mock(Client::class);

        $client->shouldReceive('request')
            ->once()
            ->with('GET', 'https://www.zhihu.com/node/ExploreAnswerListV2?params=%7B%22offset%22%3A0%2C%22type%22%3A%22month%22%7D');

        $monthlyHotExtractor = \Mockery::mock(MonthlyHotExtractor::class);

        $monthlyHotExtractor->shouldReceive('setCrawler')
            ->once()
            ->andReturnSelf();

        $monthlyHotExtractor->shouldReceive('getList')
            ->once()
            ->withNoArgs()
            ->andReturn(['item']);

        $monthlyHot = new MonthlyHot($monthlyHotExtractor);

        $monthlyHot->setClient($client);

        $this->assertEquals(['item'], $monthlyHot->getList());
    }
}
