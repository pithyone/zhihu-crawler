<?php

namespace ZhihuCrawler\Tests\Extractors;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Extractors\AnswerExtractor;
use ZhihuCrawler\Extractors\MonthlyHotExtractor;
use ZhihuCrawler\Tests\TestCase;

class MonthlyHotExtractorTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetList()
    {
        $crawler = \Mockery::mock(Crawler::class);

        $monthlyHotExtractor = new MonthlyHotExtractor($crawler, \Mockery::mock(AnswerExtractor::class));

        $crawler->shouldReceive('filter')
            ->once()
            ->with('.feed-item')
            ->andReturnSelf();

        $crawler->shouldReceive('each')
            ->once()
            ->andReturn(['item']);

        $monthlyHotExtractor->setCrawler($crawler);

        $this->assertEquals(['item'], $monthlyHotExtractor->getList(function () {
            return true;
        }));
    }
}
