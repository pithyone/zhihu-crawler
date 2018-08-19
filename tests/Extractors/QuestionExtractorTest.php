<?php

namespace ZhihuCrawler\Tests\Extractors;

use Mockery\MockInterface;
use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Extractors\AnswerExtractor;
use ZhihuCrawler\Extractors\QuestionExtractor;
use ZhihuCrawler\Tests\TestCase;

class QuestionExtractorTest extends TestCase
{
    /**
     * @var QuestionExtractor
     */
    protected $questionExtractor;

    /**
     * @var MockInterface
     */
    protected $crawler;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->crawler = \Mockery::mock(Crawler::class);

        $this->questionExtractor = new QuestionExtractor($this->crawler, \Mockery::mock(AnswerExtractor::class));
    }

    /**
     * @return void
     */
    public function testGetId()
    {
        $this->crawler->shouldReceive('getUri')
            ->once()
            ->withNoArgs()
            ->andReturn('https://www.zhihu.com/question/0');

        $this->questionExtractor->setCrawler($this->crawler);

        $this->assertEquals(0, $this->questionExtractor->getId());
    }

    /**
     * @return void
     */
    public function testGetTitle()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('.QuestionHeader-title')
            ->andReturnSelf();

        $this->crawler->shouldReceive('text')
            ->once()
            ->withNoArgs()
            ->andReturn('title');

        $this->questionExtractor->setCrawler($this->crawler);

        $this->assertEquals('title', $this->questionExtractor->getTitle());
    }

    /**
     * @return void
     */
    public function testGetDetail()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('.QuestionHeader-detail span')
            ->andReturnSelf();

        $this->crawler->shouldReceive('text')
            ->once()
            ->withNoArgs()
            ->andReturn('detail');

        $this->questionExtractor->setCrawler($this->crawler);

        $this->assertEquals('detail', $this->questionExtractor->getDetail());
    }

    /**
     * @return void
     */
    public function testGetDetailException()
    {
        $this->crawler->shouldReceive('filter->text')
            ->andThrow(\InvalidArgumentException::class);

        $this->questionExtractor->setCrawler($this->crawler);

        $this->assertEquals('', $this->questionExtractor->getDetail());
    }

    /**
     * @return void
     */
    public function testGetAnswerCount()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('meta[itemProp="answerCount"]')
            ->andReturnSelf();

        $this->crawler->shouldReceive('attr')
            ->once()
            ->with('content')
            ->andReturn('0');

        $this->questionExtractor->setCrawler($this->crawler);

        $this->assertSame(0, $this->questionExtractor->getAnswerCount());
    }
}
