<?php

namespace ZhihuCrawler\Tests;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\AnswerInterface;
use ZhihuCrawler\Collection;
use ZhihuCrawler\CrawlerDecorator;

class CollectionTest extends TestCase
{
    private $crawler;

    protected function setUp()
    {
        parent::setUp();

        $this->crawler = $this->createCompatibleMock(CrawlerDecorator::class);
    }

    protected function createCollection()
    {
        $client = $this->createClient();
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo('https://www.zhihu.com/collection/id?page=1'))->willReturn($this->createCompatibleMock(Crawler::class));

        $stub = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createCrawler'])
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->once())->method('createCrawler')->willReturn($this->crawler);

        $stub->__construct('id');

        return $stub;
    }

    public function testGetTitle()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('#zh-fav-head-title'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('title');

        $collection = $this->createCollection();

        $this->assertEquals('title', $collection->getTitle());
    }

    public function testGetDetail()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('#zh-fav-head-description'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('detail');

        $collection = $this->createCollection();

        $this->assertEquals('detail', $collection->getDetail());
    }

    public function testGetAnswerList()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('div[class="zm-item"]'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('each')->with($this->callback(function ($closure) {
            $node = $this->createCompatibleMock(CrawlerDecorator::class);
            $node->expects($this->once())->method('filter')->with($this->equalTo('.zm-item-title'))->willReturnSelf();
            $node->expects($this->once())->method('text');
            return $closure($node) instanceof AnswerInterface;
        }))->willReturn(['answer']);

        $collection = $this->createCollection();

        $this->assertEquals(['answer'], $collection->getAnswerList());
    }
}
