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
    public function testGet()
    {
        $client = \Mockery::mock(Client::class);

        $client->shouldReceive('request')
            ->once()
            ->with('GET', 'https://www.zhihu.com/question/0');

        $questionExtractor = \Mockery::mock(QuestionExtractor::class);

        $questionExtractor->shouldReceive('setCrawler')
            ->once()
            ->andReturnSelf();

        $questionExtractor->shouldReceive('toArray')
            ->once()
            ->withNoArgs()
            ->andReturn(['foo' => 'bar']);

        $question = new Question($questionExtractor);

        $question->setClient($client);

        $this->assertEquals(['foo' => 'bar'], $question->get(0));
    }
}
