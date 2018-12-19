<?php

namespace ZhihuCrawler\Tests;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\CrawlerDecorator;

class CrawlerDecoratorTest extends TestCase
{
    private $crawler;

    protected function setUp()
    {
        parent::setUp();

        $this->crawler = $this->createCompatibleMock(Crawler::class);
    }

    public function testFilter()
    {
        $this->crawler->expects($this->once())->method('filter')->with('selector')->willReturnSelf();

        $this->assertInstanceOf(CrawlerDecorator::class, (new CrawlerDecorator($this->crawler))->filter('selector'));
    }

    public function testEach()
    {
        $this->crawler->expects($this->once())->method('each')->with($this->callback(function ($closure) {
            $node = $this->createCompatibleMock(Crawler::class);
            return $closure($node, 0) === 'item';
        }))->willReturn(['item']);

        $this->assertEquals(['item'], (new CrawlerDecorator($this->crawler))->each(function ($node) {
            $this->assertInstanceOf(CrawlerDecorator::class, $node);
            return 'item';
        }));
    }

    public function testAttr()
    {
        $this->crawler->expects($this->exactly(4))->method('attr')->willReturnOnConsecutiveCalls(' foo ', '/bar', 'https://www.zhihu.com/baz', $this->throwException(new \InvalidArgumentException()));

        $stub = new CrawlerDecorator($this->crawler);

        $this->assertEquals('foo', $stub->attr('key'));
        $this->assertEquals('https://www.zhihu.com/bar', $stub->attr('href'));
        $this->assertEquals('https://www.zhihu.com/baz', $stub->attr('href'));
        $this->assertEquals('', $stub->attr('href'));
    }

    public function testText()
    {
        $this->crawler->expects($this->exactly(2))->method('text')->willReturnOnConsecutiveCalls(' foo ', $this->throwException(new \InvalidArgumentException()));

        $stub = new CrawlerDecorator($this->crawler);

        $this->assertEquals('foo', $stub->text());
        $this->assertEquals('', $stub->text());
    }
}
