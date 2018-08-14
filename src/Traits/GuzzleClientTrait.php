<?php

namespace ZhihuCrawler\Traits;

use GuzzleHttp\Client;

trait GuzzleClientTrait
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
