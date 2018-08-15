<?php

namespace ZhihuCrawler\Tests\Model;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Extractors\QuestionAnswerExtractor;
use ZhihuCrawler\Model\QuestionAnswer;
use ZhihuCrawler\Tests\TestCase;

class QuestionAnswerTest extends TestCase
{
    /**
     * @return void
     */
    public function testExtract()
    {
        $response = \Mockery::mock();

        $response->shouldReceive('getBody')
            ->twice()
            ->withNoArgs()
            ->andReturn('{"r":0,"msg":["foo","bar"]}');

        $client = \Mockery::mock(Client::class);

        $client->shouldReceive('post')
            ->with('https://www.zhihu.com/node/QuestionAnswerListV2', ['form_params' => [
                'method' => 'next',
                'params' => '{"url_token":0,"pagesize":10,"offset":0}',
            ],])
            ->andReturn($response);

        $client->shouldReceive('post')
            ->with('https://www.zhihu.com/node/QuestionAnswerListV2', ['form_params' => [
                'method' => 'next',
                'params' => '{"url_token":0,"pagesize":10,"offset":10}',
            ],])
            ->andReturn($response);

        $crawler = \Mockery::mock(Crawler::class);

        $crawler->shouldReceive('addContent')
            ->once()
            ->with('foobarfoobar');

        $questionAnswerExtractor = \Mockery::mock(QuestionAnswerExtractor::class);

        $questionAnswerExtractor->shouldReceive('setCrawler')
            ->once()
            ->with($crawler)
            ->andReturnSelf();

        $questionAnswer = new QuestionAnswer($client, $crawler, $questionAnswerExtractor);

        $this->assertInstanceOf(QuestionAnswerExtractor::class, $questionAnswer->extract(0, 15));
    }
}
