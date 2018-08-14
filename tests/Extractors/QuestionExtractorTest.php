<?php

namespace ZhihuCrawler\Tests\Extractors;

use Mockery\MockInterface;
use Symfony\Component\DomCrawler\Crawler;
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

        $this->questionExtractor = new QuestionExtractor();

        $this->crawler = \Mockery::mock(Crawler::class);
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

    /**
     * @return void
     */
    public function testGetAnswerList()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('div[tabindex="-1"]')
            ->andReturnSelf();

        $this->crawler->shouldReceive('each')
            ->once()
            ->andReturn(['answer']);

        $this->questionExtractor->setCrawler($this->crawler);

        $this->assertEquals(['answer'], $this->questionExtractor->getAnswerList());
    }

    /**
     * @return void
     */
    public function testToArray()
    {
        $questionExtractor = \Mockery::mock(QuestionExtractor::class)->makePartial();

        $questionExtractor->shouldReceive('getTitle')->andReturn('title');
        $questionExtractor->shouldReceive('getDetail')->andReturn('detail');
        $questionExtractor->shouldReceive('getAnswerCount')->andReturn(0);

        $this->assertSame([
            'title' => 'title',
            'detail' => 'detail',
            'answer_count' => 0
        ], $questionExtractor->toArray());
    }
}
