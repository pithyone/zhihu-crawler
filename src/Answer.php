<?php

namespace ZhihuCrawler;

class Answer implements AnswerInterface
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var string
     */
    private $title;

    /**
     * @param \Symfony\Component\DomCrawler\Crawler|string $node
     * @param string $title
     */
    public function __construct($node, $title)
    {
        $this->title = $title;
        $this->crawler = $this->createCrawler();
        $this->crawler->addHtmlContent(is_string($node) ? $node : $node->html());
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->crawler->filter('link')->attr('href');
    }

    /**
     * @return int
     */
    public function getVoteCount()
    {
        return (int)$this->crawler->filter('.zm-item-vote-info')->attr('data-votecount');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        try {
            return $this->crawler->filter('a[class="author-link"]')->text();
        } catch (\InvalidArgumentException $e) {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getAuthorLink()
    {
        try {
            return $this->crawler->filter('a[class="author-link"]')->attr('href');
        } catch (\InvalidArgumentException $e) {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getAuthorBio()
    {
        try {
            return $this->crawler->filter('span[class="bio"]')->attr('title');
        } catch (\InvalidArgumentException $e) {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        $summary = $this->crawler->filter('.zh-summary')->text();

        return trim(str_replace('显示全部', '', $summary));
    }

    /**
     * @return array
     */
    public function getImageList()
    {
        return $this->crawler->filter('div[class^="zm-editable-content"]')
            ->filter('noscript img')
            ->each(function (Crawler $node) {
                return $node->attr('src');
            });
    }

    /**
     * @return int
     */
    public function getCreated()
    {
        try {
            return (int)$this->crawler->filter('.zm-item-answer')->attr('data-created');
        } catch (\InvalidArgumentException $e) {
            return 0;
        }
    }

    /**
     * @return Crawler
     */
    protected function createCrawler()
    {
        return new Crawler();
    }
}
