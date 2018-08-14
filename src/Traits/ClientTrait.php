<?php

namespace ZhihuCrawler\Traits;

use Goutte\Client;

trait ClientTrait
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }
}
