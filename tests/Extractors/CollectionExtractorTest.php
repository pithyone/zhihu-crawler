<?php

namespace ZhihuCrawler\Tests\Extractors;

use Mockery\MockInterface;
use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Extractors\CollectionExtractor;
use ZhihuCrawler\Tests\TestCase;

class CollectionExtractorTest extends TestCase
{
    /**
     * @var CollectionExtractor
     */
    protected $collectionExtractor;

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

        $this->collectionExtractor = new CollectionExtractor();

        $this->crawler = \Mockery::mock(Crawler::class);
    }

    /**
     * @return void
     */
    public function testGetTitle()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('#zh-fav-head-title')
            ->andReturnSelf();

        $this->crawler->shouldReceive('text')
            ->once()
            ->withNoArgs()
            ->andReturn('title');

        $this->collectionExtractor->setCrawler($this->crawler);

        $this->assertEquals('title', $this->collectionExtractor->getTitle());
    }

    /**
     * @return void
     */
    public function testGetList()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('div[class="zm-item"]')
            ->andReturnSelf();

        $this->crawler->shouldReceive('each')
            ->once()
            ->andReturn(['item']);

        $this->collectionExtractor->setCrawler($this->crawler);

        $this->assertEquals(['item'], $this->collectionExtractor->getList());
    }

    /**
     * @return void
     */
    public function testToArray()
    {
        $collectionExtractor = \Mockery::mock(CollectionExtractor::class)->makePartial();

        $collectionExtractor->shouldReceive('getTitle')->andReturn('title');
        $collectionExtractor->shouldReceive('getList')->andReturn(['item']);

        $this->assertEquals([
            'title' => 'title',
            'list' => ['item']
        ], $collectionExtractor->toArray());
    }
}
