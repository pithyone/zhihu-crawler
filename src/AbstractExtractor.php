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
     * @var CrawlerDecorator
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

        $this->setCrawler();

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
            $this->setCrawler();
        }

        $closure = $this->getAnswer();

        return $this->crawler->filter($this->getAnswerListSelector())->each($closure);
    }

    /**
     * @return Client
     * @codeCoverageIgnore
     */
    protected function createClient()
    {
        return new Client();
    }

    /**
     * @param Crawler $crawler
     * @return CrawlerDecorator
     */
    protected function createCrawler(Crawler $crawler)
    {
        return new CrawlerDecorator($crawler);
    }

    /**
     * @param int $page
     * @return string
     */
    abstract protected function getRequestUri($page);

    /**
     * @return string
     */
    abstract protected function getAnswerListSelector();

    /**
     * @return string
     */
    abstract protected function getAnswerTitleSelector();

    /**
     * @return void
     */
    private function setCrawler()
    {
        $crawler = $this->client->request('GET', $this->getRequestUri($this->page));

        $this->crawler = $this->createCrawler($crawler);
    }

    /**
     * @return \Closure
     */
    private function getAnswer()
    {
        return function (CrawlerDecorator $node) {
            $title = $node->filter($this->getAnswerTitleSelector())->text();
            return new Answer($node, $title);
        };
    }
}
