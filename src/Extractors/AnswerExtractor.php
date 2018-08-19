<?php

namespace ZhihuCrawler\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class AnswerExtractor
{
    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var string
     */
    protected $questionTitle;

    /**
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int)pathinfo($this->getLink())['basename'];
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        try {
            return $this->crawler->filter('a[class="author-link"]')->text();
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getAuthorLink()
    {
        try {
            return $this->validateUrl($this->crawler->filter('a[class="author-link"]')->attr('href'));
        } catch (\Exception $e) {
            return '';
        }
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
     * @return string
     */
    public function getSummary()
    {
        $summary = $this->crawler->filter('.zh-summary')->text();

        return str_replace('显示全部', '', $summary);
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->validateUrl($this->crawler->filter('link')->attr('href'));
    }

    /**
     * @return int
     */
    public function getVoteCount()
    {
        return (int)$this->crawler->filter('.zm-item-vote-info')->attr('data-votecount');
    }

    /**
     * @param Crawler $crawler
     */
    public function setCrawler($crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @return string
     */
    public function getQuestionTitle()
    {
        return $this->questionTitle;
    }

    /**
     * @param string $questionTitle
     */
    public function setQuestionTitle($questionTitle)
    {
        $this->questionTitle = $questionTitle;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function validateUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        } else {
            return $url ? 'https://www.zhihu.com' . $url : '';
        }
    }
}
