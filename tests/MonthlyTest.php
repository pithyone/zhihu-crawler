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
        $client->expects($this->exactly(2))
            ->method('request')
            ->withConsecutive([
                $this->equalTo('GET'),
                $this->equalTo('https://www.zhihu.com/node/ExploreAnswerListV2?params=%7B%22offset%22%3A0%2C%22type%22%3A%22month%22%7D')
            ], [
                $this->equalTo('GET'),
                $this->equalTo('https://www.zhihu.com/node/ExploreAnswerListV2?params=%7B%22offset%22%3A5%2C%22type%22%3A%22month%22%7D')
            ])
            ->willReturn($crawler);

        $stub = $this->getMockBuilder(Monthly::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient'])
            ->getMock();

        $stub->expects($this->once())->method('createClient')->willReturn($client);

        $stub->__construct();

        $this->assertEquals(['answer'], $stub->getAnswerList(2));
    }
}
