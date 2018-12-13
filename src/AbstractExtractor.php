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
     * @var ZhihuCrawler
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

        $this->crawler = $this->createCrawler();

        if (200 !== $this->client->getInternalResponse()->getStatus()) {
            throw new NotFoundException();
        }
    }

    /**
     * @param int $page
     *
     * @return array
     */
    public function getAnswerList($page = 1)
    {
        if ($this->page !== $page) {
            $this->page = $page;
            $this->crawler = $this->createCrawler();
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
     * @param Crawler $crawler
     *
     * @return ZhihuCrawler
     */
    protected function createZhihuCrawler($crawler)
    {
        return ZhihuCrawler::createFromCrawler($crawler);
    }

    /**
     * @param int $page
     *
     * @return Crawler
     */
    abstract protected function makeRequest($page);

    /**
     * @return array
     */
    abstract protected function extractAnswerList();

    /**
     * @return ZhihuCrawler
     */
    private function createCrawler()
    {
        $crawler = $this->makeRequest($this->page);

        return $this->createZhihuCrawler($crawler);
    }
}
