<?php

namespace ZhihuCrawler\Tests\Model;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Extractors\QuestionExtractor;
use ZhihuCrawler\Model\Answer;
use ZhihuCrawler\Tests\TestCase;

class AnswerTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetList()
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

        $questionExtractor = \Mockery::mock(QuestionExtractor::class);

        $questionExtractor->shouldReceive('setCrawler')
            ->once()
            ->with($crawler)
            ->andReturnSelf();

        $questionExtractor->shouldReceive('getAnswerList')
            ->once()
            ->withNoArgs()
            ->andReturn(['item']);

        $answer = new Answer($questionExtractor);

        $answer->setClient($client);
        $answer->setCrawler($crawler);

        $this->assertEquals(['item'], $answer->getList(0, 15));
    }
}
