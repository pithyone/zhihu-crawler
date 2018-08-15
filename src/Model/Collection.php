<?php

namespace ZhihuCrawler\Model;

use Goutte\Client;
use ZhihuCrawler\Extractors\CollectionExtractor;

class Collection
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var CollectionExtractor
     */
    protected $collectionExtractor;

    /**
     * @param Client $client
     * @param CollectionExtractor $collectionExtractor
     */
    public function __construct(Client $client, CollectionExtractor $collectionExtractor)
    {
        $this->client = $client;
        $this->collectionExtractor = $collectionExtractor;
    }

    /**
     * @param int $id
     * @return CollectionExtractor
     */
    public function extract($id)
    {
        $crawler = $this->client->request('GET', 'https://www.zhihu.com/collection/' . $id);

        $this->collectionExtractor->setCrawler($crawler);

        return $this->collectionExtractor;
    }
}
