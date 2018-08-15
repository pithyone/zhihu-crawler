<?php

namespace ZhihuCrawler\Tests\Model;

use Goutte\Client;
use ZhihuCrawler\Extractors\QuestionExtractor;
use ZhihuCrawler\Model\Question;
use ZhihuCrawler\Tests\TestCase;

class QuestionTest extends TestCase
{
    /**
     * @return void
     */
    public function testExtract()
    {
        $client = \Mockery::mock(Client::class);

        $client->shouldReceive('request')
            ->once()
            ->with('GET', 'https://www.zhihu.com/question/0');

        $questionExtractor = \Mockery::mock(QuestionExtractor::class);

        $questionExtractor->shouldReceive('setCrawler')
            ->once()
            ->andReturnSelf();

        $question = new Question($client, $questionExtractor);

        $this->assertInstanceOf(QuestionExtractor::class, $question->extract(0));
    }
}
