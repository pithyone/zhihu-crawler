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

        $this->crawler = $this->createZhihuCrawler();

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
            $this->crawler = $this->createZhihuCrawler();
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
     * @return ZhihuCrawler
     */
    protected function createZhihuCrawler()
    {
        return ZhihuCrawler::createFromCrawler($this->makeRequest($this->page));
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
