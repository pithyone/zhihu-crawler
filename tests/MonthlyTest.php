<?php

namespace ZhihuCrawler\Tests;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Monthly;

class MonthlyTest extends TestCase
{
    public function testGetAnswerList()
    {
        $crawler = $this->createMock(Crawler::class);
        $crawler->expects($this->once())->method('filter')->with($this->equalTo('.feed-item'))->willReturnSelf();
        $crawler->expects($this->once())->method('each')->willReturn(['answer']);

        $client = $this->getClient();
        $client->expects($this->once())
            ->method('request')
            ->with($this->equalTo('GET'), $this->equalTo('https://www.zhihu.com/node/ExploreAnswerListV2?params=%7B%22offset%22%3A0%2C%22type%22%3A%22month%22%7D'));

        $stub = $this->getMockBuilder(Monthly::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createZhihuCrawler'])
            ->getMock();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->once())->method('createZhihuCrawler')->willReturn($crawler);

        $stub->__construct();

        $this->assertEquals(['answer'], $stub->getAnswerList());
    }
}
