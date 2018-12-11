<?php

namespace ZhihuCrawler\Tests;

use ZhihuCrawler\Crawler;

class CrawlerTest extends TestCase
{
    public function testAttr()
    {
        $stub = $this->getMockBuilder(Crawler::class)
            ->setMethods(['getParentAttr'])
            ->getMock();

        $stub->expects($this->exactly(3))->method('getParentAttr')->willReturnOnConsecutiveCalls('foo', '/bar', 'https://www.zhihu.com/baz');

        $this->assertEquals('foo', $stub->attr('key'));
        $this->assertEquals('https://www.zhihu.com/bar', $stub->attr('href'));
        $this->assertEquals('https://www.zhihu.com/baz', $stub->attr('href'));
    }
}
