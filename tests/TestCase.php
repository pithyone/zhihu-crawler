<?php

namespace ZhihuCrawler\Tests;

use Goutte\Client;
use Symfony\Component\BrowserKit\Response;
use ZhihuCrawler\Answer;
use ZhihuCrawler\Collection;
use ZhihuCrawler\Question;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function getClient($status = 200)
    {
        $response = $this->createMock(Response::class);
        $response->method('getStatus')->willReturn($status);

        $client = $this->createMock(Client::class);
        $client->method('getInternalResponse')->willReturn($response);

        return $client;
    }

    protected function createAnswer($crawler)
    {
        $stub = $this->getMockBuilder(Answer::class)
            ->disableOriginalConstructor()
            ->setMethods(['createCrawler'])
            ->getMock();

        $stub->expects($this->once())->method('createCrawler')->willReturn($crawler);

        $stub->__construct('string', 'title');

        return $stub;
    }

    protected function createCollection($crawler)
    {
        $client = $this->getClient();
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo("https://www.zhihu.com/collection/id?page=1"))->willReturn($crawler);

        $stub = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient'])
            ->getMock();

        $stub->expects($this->once())->method('createClient')->willReturn($client);

        $stub->__construct('id');

        return $stub;
    }

    protected function createQuestion($crawler)
    {
        $client = $this->getClient();
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo('https://www.zhihu.com/question/id'))->willReturn($crawler);

        $stub = $this->getMockBuilder(Question::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient'])
            ->getMock();

        $stub->expects($this->once())->method('createClient')->willReturn($client);

        $stub->__construct('id');

        return $stub;
    }
}
