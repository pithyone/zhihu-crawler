<?php

namespace ZhihuCrawler\Tests;

use ZhihuCrawler\AbstractExtractor;

class AbstractExtractorTest extends TestCase
{
    public function testConstruct()
    {
        $stub = $this->getMockBuilder(AbstractExtractor::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient'])
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('createClient')->willReturn($this->getClient());
        $stub->expects($this->once())->method('makeRequest')->with($this->equalTo(1));

        $stub->__construct();
    }

    /**
     * @expectedException \ZhihuCrawler\NotFoundException
     */
    public function testNotFound()
    {
        $stub = $this->getMockBuilder(AbstractExtractor::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient'])
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('createClient')->willReturn($this->getClient(404));

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
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('makeRequest')->withConsecutive($this->equalTo(2));

        $stub->getAnswerList(2);
    }
}
