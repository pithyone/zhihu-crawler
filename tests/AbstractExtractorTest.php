<?php

namespace ZhihuCrawler\Tests;

use ZhihuCrawler\AbstractExtractor;

class AbstractExtractorTest extends TestCase
{
    /**
     * @expectedException \ZhihuCrawler\NotFoundException
     */
    public function testNotFound()
    {
        $stub = $this->getMockBuilder(AbstractExtractor::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createZhihuCrawler'])
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('createClient')->willReturn($this->getClient(404));
        $stub->expects($this->once())->method('makeRequest')->with($this->equalTo(1));
        $stub->expects($this->once())->method('createZhihuCrawler');

        $stub->__construct();
    }

    public function testGetAnswerList()
    {
        $stub = $this->getMockBuilder(AbstractExtractor::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('extractAnswerList')->willReturn(['answer']);

        $this->assertEquals(['answer'], $stub->getAnswerList());
    }

    public function testGetAnswerListWithNextPage()
    {
        $stub = $this->getMockBuilder(AbstractExtractor::class)
            ->disableOriginalConstructor()
            ->setMethods(['createZhihuCrawler'])
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('makeRequest')->with($this->equalTo(2));
        $stub->expects($this->once())->method('createZhihuCrawler');

        $stub->getAnswerList(2);
    }
}
