<?php

namespace ZhihuCrawler\Tests;

use ZhihuCrawler\Answer;
use ZhihuCrawler\Crawler;

class AnswerTest extends TestCase
{
    const LINK = 'https://www.zhihu.com/foo';

    private $crawler;

    protected function setUp()
    {
        parent::setUp();

        $this->crawler = $this->createMock(Crawler::class);
    }

    public function testConstructAndGet()
    {
        $this->crawler->expects($this->once())->method('addHtmlContent')->with($this->equalTo('string'));

        $answer = $this->createAnswer($this->crawler);

        $this->assertEquals('title', $answer->getTitle());
    }

    public function testConstructWithCrawler()
    {
        $this->crawler->expects($this->once())->method('addHtmlContent')->with($this->equalTo('<body><p>text</p></body>'));

        $stub = $this->getMockBuilder(Answer::class)
            ->disableOriginalConstructor()
            ->setMethods(['createCrawler'])
            ->getMock();

        $stub->expects($this->once())->method('createCrawler')->willReturn($this->crawler);

        $c = new \Symfony\Component\DomCrawler\Crawler();
        $c->addHtmlContent('<body><p>text</p></body>');

        $stub->__construct($c, 'title');
    }

    public function testGetLink()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('link'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('attr')->with($this->equalTo('href'))->willReturn(self::LINK);

        $answer = $this->createAnswer($this->crawler);

        $this->assertEquals(self::LINK, $answer->getLink());
    }

    public function testGetVoteCount()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('.zm-item-vote-info'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('attr')->with($this->equalTo('data-votecount'))->willReturn('100');

        $answer = $this->createAnswer($this->crawler);

        $this->assertSame(100, $answer->getVoteCount());
    }

    public function testGetAuthor()
    {
        $this->crawler->expects($this->exactly(2))->method('filter')->with($this->equalTo('a[class="author-link"]'))->willReturnSelf();
        $this->crawler->expects($this->exactly(2))->method('text')->willReturnOnConsecutiveCalls('author', $this->throwException(new \InvalidArgumentException()));

        $answer = $this->createAnswer($this->crawler);

        $this->assertEquals('author', $answer->getAuthor());
        $this->assertEquals('', $answer->getAuthor());
    }

    public function testGetAuthorLink()
    {
        $this->crawler->expects($this->exactly(2))->method('filter')->with($this->equalTo('a[class="author-link"]'))->willReturnSelf();
        $this->crawler->expects($this->exactly(2))->method('attr')->with($this->equalTo('href'))->willReturnOnConsecutiveCalls(self::LINK, $this->throwException(new \InvalidArgumentException()));

        $answer = $this->createAnswer($this->crawler);

        $this->assertEquals(self::LINK, $answer->getAuthorLink());
        $this->assertEquals('', $answer->getAuthorLink());
    }

    public function testGetAuthorBio()
    {
        $this->crawler->expects($this->exactly(2))->method('filter')->with($this->equalTo('span[class="bio"]'))->willReturnSelf();
        $this->crawler->expects($this->exactly(2))->method('attr')->with($this->equalTo('title'))->willReturnOnConsecutiveCalls('title', $this->throwException(new \InvalidArgumentException()));

        $answer = $this->createAnswer($this->crawler);

        $this->assertEquals('title', $answer->getAuthorBio());
        $this->assertEquals('', $answer->getAuthorBio());
    }

    public function testGetSummary()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('.zh-summary'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('显示全部');

        $answer = $this->createAnswer($this->crawler);

        $this->assertEquals('', $answer->getSummary());
    }

    public function testGetImageList()
    {
        $this->crawler->expects($this->exactly(2))->method('filter')->withConsecutive([$this->equalTo('div[class^="zm-editable-content"]')], [$this->equalTo('noscript img')])->willReturnSelf();
        $this->crawler->expects($this->once())->method('each')->willReturn(['image']);

        $answer = $this->createAnswer($this->crawler);

        $this->assertEquals(['image'], $answer->getImageList());
    }

    public function testGetCreated()
    {
        $this->crawler->expects($this->exactly(2))->method('filter')->with($this->equalTo('.zm-item-answer'))->willReturnSelf();
        $this->crawler->expects($this->exactly(2))->method('attr')->with($this->equalTo('data-created'))->willReturnOnConsecutiveCalls('123456789', $this->throwException(new \InvalidArgumentException()));

        $answer = $this->createAnswer($this->crawler);

        $this->assertSame(123456789, $answer->getCreated());
        $this->assertSame(0, $answer->getCreated());
    }
}
