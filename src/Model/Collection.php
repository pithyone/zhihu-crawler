<?php

namespace ZhihuCrawler\Model;

use ZhihuCrawler\Extractors\CollectionExtractor;
use ZhihuCrawler\Traits\ClientTrait;

class Collection
{
    use ClientTrait;

    /**
     * @var CollectionExtractor
     */
    protected $collectionExtractor;

    /**
     * @param CollectionExtractor $collectionExtractor
     */
    public function __construct(CollectionExtractor $collectionExtractor)
    {
        $this->collectionExtractor = $collectionExtractor;
    }

    /**
     * @param int $id
     * @return array
     */
    public function get($id)
    {
        $crawler = $this->client->request('GET', 'https://www.zhihu.com/collection/' . $id);

        $this->collectionExtractor->setCrawler($crawler);

        return $this->collectionExtractor->toArray();
    }
}
