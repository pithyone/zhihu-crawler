<?php

namespace ZhihuCrawler;

class Answer implements AnswerInterface
{
    /**
     * @var ZhihuCrawler
     */
    private $crawler;

    /**
     * @var string
     */
    private $title;

    /**
     * @param ZhihuCrawler $crawler
     * @param string $title
     */
    public function __construct($crawler, $title)
    {
        $this->crawler = $crawler;
        $this->title = $title;
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
        return $this->crawler->filter('a[class="author-link"]')->text();
    }

    /**
     * @return string
     */
    public function getAuthorLink()
    {
        return $this->crawler->filter('a[class="author-link"]')->attr('href');
    }

    /**
     * @return string
     */
    public function getAuthorBio()
    {
        return $this->crawler->filter('span[class="bio"]')->attr('title');
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
            ->each(function (ZhihuCrawler $node) {
                return $node->attr('src');
            });
    }

    /**
     * @return int
     */
    public function getCreated()
    {
        return (int)$this->crawler->filter('.zm-item-answer')->attr('data-created');
    }
}
