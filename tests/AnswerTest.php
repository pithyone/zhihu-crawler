<?php

namespace ZhihuCrawler\Tests;

use ZhihuCrawler\Answer;
use ZhihuCrawler\ZhihuCrawler;

class AnswerTest extends TestCase
{
    const LINK = 'https://www.zhihu.com/foo';

    private $crawler;

    protected function setUp()
    {
        parent::setUp();

        $this->crawler = $this->createMockCopy(ZhihuCrawler::class);
    }

    public function testConstructAndGet()
    {
        $answer = new Answer($this->crawler, 'title');

        $this->assertEquals('title', $answer->getTitle());
    }

    public function testGetLink()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('link'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('attr')->with($this->equalTo('href'))->willReturn('url');

        $answer = new Answer($this->crawler, '');

        $this->assertEquals('url', $answer->getLink());
    }

    public function testGetVoteCount()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('.zm-item-vote-info'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('attr')->with($this->equalTo('data-votecount'))->willReturn('100');

        $answer = new Answer($this->crawler, '');

        $this->assertSame(100, $answer->getVoteCount());
    }

    public function testGetAuthor()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('a[class="author-link"]'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('author');

        $answer = new Answer($this->crawler, '');

        $this->assertEquals('author', $answer->getAuthor());
    }

    public function testGetAuthorLink()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('a[class="author-link"]'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('attr')->with($this->equalTo('href'))->willReturn('url');

        $answer = new Answer($this->crawler, '');

        $this->assertEquals('url', $answer->getAuthorLink());
    }

    public function testGetAuthorBio()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('span[class="bio"]'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('attr')->with($this->equalTo('title'))->willReturn('title');

        $answer = new Answer($this->crawler, '');

        $this->assertEquals('title', $answer->getAuthorBio());
    }

    public function testGetSummary()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('.zh-summary'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('内容 显示全部');

        $answer = new Answer($this->crawler, '');

        $this->assertEquals('内容', $answer->getSummary());
    }

    public function testGetImageList()
    {
        $this->crawler->expects($this->exactly(2))->method('filter')->withConsecutive([$this->equalTo('div[class^="zm-editable-content"]')], [$this->equalTo('noscript img')])->willReturnSelf();
        $this->crawler->expects($this->once())->method('each')->willReturn(['image']);

        $answer = new Answer($this->crawler, '');

        $this->assertEquals(['image'], $answer->getImageList());
    }

    public function testGetCreated()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('.zm-item-answer'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('attr')->with($this->equalTo('data-created'))->willReturn('123456789');

        $answer = new Answer($this->crawler, '');

        $this->assertSame(123456789, $answer->getCreated());
    }
}
