<?php

namespace ZhihuCrawler;

use Symfony\Component\DomCrawler\Crawler;

class Collection extends AbstractExtractor
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     * @throws NotFoundException
     */
    public function __construct($id)
    {
        $this->id = $id;

        parent::__construct();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->crawler->filter('#zh-fav-head-title')->text();
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return $this->crawler->filter('#zh-fav-head-description')->text();
    }

    /**
     * @param int $page
     * @return Crawler
     */
    protected function makeRequest($page)
    {
        return $this->client->request('GET', "https://www.zhihu.com/collection/{$this->id}?page={$page}");
    }

    /**
     * @return array
     */
    protected function extractAnswerList()
    {
        return $this->crawler->filter('div[class="zm-item"]')->each(function (ZhihuCrawler $node) {
            $title = $node->filter('.zm-item-title')->text();

            return new Answer($node, $title);
        });
    }
}
