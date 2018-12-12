<?php

namespace ZhihuCrawler\Tests;

use Symfony\Component\DomCrawler\Crawler;

class CollectionTest extends TestCase
{
    private $crawler;

    protected function setUp()
    {
        parent::setUp();

        $this->crawler = $this->createMock(Crawler::class);
    }

    public function testGetTitle()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('#zh-fav-head-title'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('title');

        $collection = $this->createCollection($this->crawler);

        $this->assertEquals('title', $collection->getTitle());
    }

    public function testGetDetail()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('#zh-fav-head-description'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('detail');

        $collection = $this->createCollection($this->crawler);

        $this->assertEquals('detail', $collection->getDetail());
    }

    public function testGetAnswerList()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('div[class="zm-item"]'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('each')->willReturn(['answer']);

        $collection = $this->createCollection($this->crawler);

        $this->assertEquals(['answer'], $collection->getAnswerList());
    }
}
