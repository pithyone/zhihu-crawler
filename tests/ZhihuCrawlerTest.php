<?php

namespace ZhihuCrawler\Tests;

use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\ZhihuCrawler;

class ZhihuCrawlerTest extends TestCase
{
    public function testCreateFromCrawler()
    {
        $this->assertInstanceOf(ZhihuCrawler::class, ZhihuCrawler::createFromCrawler($this->createMock(Crawler::class)));
    }

    public function testAttr()
    {
        $stub = $this->getMockBuilder(ZhihuCrawler::class)
            ->setMethods(['getParentAttr'])
            ->getMock();

        $stub->expects($this->exactly(4))->method('getParentAttr')->willReturnOnConsecutiveCalls(' foo ', '/bar', 'https://www.zhihu.com/baz', $this->throwException(new \InvalidArgumentException()));

        $this->assertEquals('foo', $stub->attr('key'));
        $this->assertEquals('https://www.zhihu.com/bar', $stub->attr('href'));
        $this->assertEquals('https://www.zhihu.com/baz', $stub->attr('href'));
        $this->assertEquals('', $stub->attr('href'));
    }

    public function testText()
    {
        $stub = $this->getMockBuilder(ZhihuCrawler::class)
            ->setMethods(['getParentText'])
            ->getMock();

        $stub->expects($this->exactly(2))->method('getParentText')->willReturnOnConsecutiveCalls(' foo ', $this->throwException(new \InvalidArgumentException()));

        $this->assertEquals('foo', $stub->text());
        $this->assertEquals('', $stub->text());
    }

    public function testEach()
    {
        $stub = $this->getMockBuilder(ZhihuCrawler::class)
            ->disableOriginalConstructor()
            ->setMethods(['createSubZhihuCrawler', 'getIterator'])
            ->getMock();

        $stub->expects($this->once())->method('createSubZhihuCrawler')->willReturn('foo');
        $stub->expects($this->once())->method('getIterator')->willReturn(new \ArrayIterator(['bar']));

        $this->assertEquals([['foo', 0]], $stub->each(function ($node, $i) {
            return [$node, $i];
        }));
    }
}
