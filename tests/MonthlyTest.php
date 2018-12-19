<?php

namespace ZhihuCrawler\Tests;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\AnswerInterface;
use ZhihuCrawler\CrawlerDecorator;
use ZhihuCrawler\Monthly;

class MonthlyTest extends TestCase
{
    public function testGetAnswerList()
    {
        $crawler = $this->createCompatibleMock(CrawlerDecorator::class);
        $crawler->expects($this->once())->method('filter')->with($this->equalTo('.feed-item'))->willReturnSelf();
        $crawler->expects($this->once())->method('each')->with($this->callback(function ($closure) {
            $node = $this->createCompatibleMock(CrawlerDecorator::class);
            $node->expects($this->once())->method('filter')->with($this->equalTo('.question_link'))->willReturnSelf();
            $node->expects($this->once())->method('text');
            return $closure($node) instanceof AnswerInterface;
        }))->willReturn(['answer']);

        $client = $this->createClient();
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo('https://www.zhihu.com/node/ExploreAnswerListV2?params=%7B%22offset%22%3A0%2C%22type%22%3A%22month%22%7D'))->willReturn($this->createCompatibleMock(Crawler::class));

        $stub = $this->getMockBuilder(Monthly::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createCrawler'])
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->once())->method('createCrawler')->willReturn($crawler);

        $stub->__construct();

        $this->assertEquals(['answer'], $stub->getAnswerList());
    }
}
