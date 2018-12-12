<?php

namespace ZhihuCrawler\Tests;

use Goutte\Client;
use Symfony\Component\BrowserKit\Response;
use ZhihuCrawler\Collection;
use ZhihuCrawler\Question;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function getClient($status = 200)
    {
        $response = $this->createMockCopy(Response::class);
        $response->method('getStatus')->willReturn($status);

        $client = $this->createMockCopy(Client::class);
        $client->method('getInternalResponse')->willReturn($response);

        return $client;
    }

    protected function createCollection($crawler)
    {
        $client = $this->getClient();
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo("https://www.zhihu.com/collection/id?page=1"));

        $stub = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createZhihuCrawler'])
            ->getMock();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->once())->method('createZhihuCrawler')->willReturn($crawler);

        $stub->__construct('id');

        return $stub;
    }

    protected function createQuestion($crawler)
    {
        $client = $this->getClient();
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo('https://www.zhihu.com/question/id'));

        $stub = $this->getMockBuilder(Question::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createZhihuCrawler'])
            ->getMock();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->once())->method('createZhihuCrawler')->willReturn($crawler);

        $stub->__construct('id');

        return $stub;
    }

    protected function createMockCopy($originalClassName)
    {
        if (is_callable('parent::createMock')) {
            return parent::createMock($originalClassName);
        } elseif (is_callable('parent::getMock')) {
            return parent::getMock($originalClassName);
        } else {
            throw new \InvalidArgumentException();
        }
    }
}
