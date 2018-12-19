<?php

namespace ZhihuCrawler\Tests;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\AbstractExtractor;
use ZhihuCrawler\AnswerInterface;
use ZhihuCrawler\CrawlerDecorator;

class AbstractExtractorTest extends TestCase
{
    /**
     * @expectedException \ZhihuCrawler\NotFoundException
     */
    public function testConstructWithException()
    {
        $client = $this->createClient(404);
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo('uri'))->willReturn($this->createCompatibleMock(Crawler::class));

        $stub = $this->getMockBuilder(AbstractExtractor::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient'])
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->once())->method('getRequestUri')->with($this->equalTo(1))->willReturn('uri');

        $stub->__construct();
    }

    public function testGetAnswerList()
    {
        $crawler = $this->createCompatibleMock(CrawlerDecorator::class);
        $crawler->expects($this->once())->method('filter')->willReturnSelf();
        $crawler->expects($this->once())->method('each')->with($this->callback(function ($closure) {
            $node = $this->createCompatibleMock(CrawlerDecorator::class);
            $node->expects($this->once())->method('filter')->willReturnSelf();
            $node->expects($this->once())->method('text');

            return $closure($node) instanceof AnswerInterface;
        }))->willReturn(['answer']);

        $client = $this->createClient();
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo('uri'))->willReturn($this->createCompatibleMock(Crawler::class));

        $stub = $this->getMockBuilder(AbstractExtractor::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createCrawler'])
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->once())->method('createCrawler')->willReturn($crawler);
        $stub->expects($this->once())->method('getRequestUri')->with($this->equalTo(1))->willReturn('uri');

        $stub->__construct();

        $this->assertEquals(['answer'], $stub->getAnswerList());
    }

    public function testGetAnswerListWithNextPage()
    {
        $crawler = $this->createCompatibleMock(CrawlerDecorator::class);
        $crawler->expects($this->once())->method('filter')->willReturnSelf();

        $client = $this->createClient();
        $client->expects($this->exactly(2))->method('request')->willReturn($this->createCompatibleMock(Crawler::class));

        $stub = $this->getMockBuilder(AbstractExtractor::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createCrawler'])
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->exactly(2))->method('createCrawler')->willReturn($crawler);
        $stub->expects($this->exactly(2))->method('getRequestUri')->withConsecutive([$this->equalTo(1)], [$this->equalTo(2)])->willReturn('uri');

        $stub->__construct();

        $stub->getAnswerList(2);
    }
}
