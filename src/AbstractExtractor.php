<?php

namespace ZhihuCrawler;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractExtractor
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var int
     */
    private $page = 1;

    /**
     * @throws NotFoundException
     */
    public function __construct()
    {
        $this->client = $this->createClient();

        $this->crawler = $this->makeRequest($this->page);

        if ($this->client->getInternalResponse()->getStatus() !== 200) {
            throw new NotFoundException();
        }
    }

    /**
     * @param int $page
     * @return array
     */
    public function getAnswerList($page = 1)
    {
        if ($this->page !== $page) {
            $this->page = $page;
            $this->crawler = $this->makeRequest($page);
        }

        return $this->extractAnswerList();
    }

    /**
     * @return Client
     */
    protected function createClient()
    {
        return new Client();
    }

    /**
     * @param int $page
     * @return Crawler
     */
    abstract protected function makeRequest($page);

    /**
     * @return array
     */
    abstract protected function extractAnswerList();
}
