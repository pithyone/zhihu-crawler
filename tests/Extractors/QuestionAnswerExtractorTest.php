<?php

namespace ZhihuCrawler\Tests\Extractors;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Extractors\AnswerExtractor;
use ZhihuCrawler\Extractors\QuestionAnswerExtractor;
use ZhihuCrawler\Tests\TestCase;

class QuestionAnswerExtractorTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetList()
    {
        $crawler = \Mockery::mock(Crawler::class);

        $questionAnswerExtractor = new QuestionAnswerExtractor($crawler, \Mockery::mock(AnswerExtractor::class));

        $crawler->shouldReceive('filter')
            ->once()
            ->with('div[tabindex="-1"]')
            ->andReturnSelf();

        $crawler->shouldReceive('each')
            ->once()
            ->andReturn(['answer']);

        $questionAnswerExtractor->setCrawler($crawler);

        $this->assertEquals(['answer'], $questionAnswerExtractor->getList(function () {
            return true;
        }));
    }
}
