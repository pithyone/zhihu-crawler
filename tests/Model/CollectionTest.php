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
    public function testExtract()
    {
        $client = \Mockery::mock(Client::class);

        $client->shouldReceive('request')
            ->once()
            ->with('GET', 'https://www.zhihu.com/collection/0');

        $collectionExtractor = \Mockery::mock(CollectionExtractor::class);

        $collectionExtractor->shouldReceive('setCrawler')
            ->once()
            ->andReturnSelf();

        $collection = new Collection($client, $collectionExtractor);

        $this->assertInstanceOf(CollectionExtractor::class, $collection->extract(0));
    }
}
