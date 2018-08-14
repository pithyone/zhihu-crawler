<?php

namespace ZhihuCrawler\Tests\Model;

use Goutte\Client;
use ZhihuCrawler\Extractors\CollectionExtractor;
use ZhihuCrawler\Model\Collection;
use ZhihuCrawler\Tests\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @return void
     */
    public function testGet()
    {
        $client = \Mockery::mock(Client::class);

        $client->shouldReceive('request')
            ->once()
            ->with('GET', 'https://www.zhihu.com/collection/0');

        $collectionExtractor = \Mockery::mock(CollectionExtractor::class);

        $collectionExtractor->shouldReceive('setCrawler')
            ->once()
            ->andReturnSelf();

        $collectionExtractor->shouldReceive('toArray')
            ->once()
            ->withNoArgs()
            ->andReturn(['foo' => 'bar']);

        $collection = new Collection($collectionExtractor);

        $collection->setClient($client);

        $this->assertEquals(['foo' => 'bar'], $collection->get(0));
    }
}
