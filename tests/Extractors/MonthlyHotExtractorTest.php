<?php

namespace ZhihuCrawler\Tests\Extractors;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Extractors\MonthlyHotExtractor;
use ZhihuCrawler\Tests\TestCase;

class MonthlyHotExtractorTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetList()
    {
        $monthlyHotExtractor = new MonthlyHotExtractor();

        $crawler = \Mockery::mock(Crawler::class);

        $crawler->shouldReceive('filter')
            ->once()
            ->with('.feed-item')
            ->andReturnSelf();

        $crawler->shouldReceive('each')
            ->once()
            ->andReturn(['item']);

        $monthlyHotExtractor->setCrawler($crawler);

        $this->assertEquals(['item'], $monthlyHotExtractor->getList());
    }
}
