<?php

namespace ZhihuCrawler;

use Symfony\Component\DomCrawler\Crawler;

class CrawlerDecorator
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param string $selector
     *
     * @return self
     */
    public function filter($selector)
    {
        return new static($this->crawler->filter($selector));
    }

    /**
     * @param \Closure $closure
     *
     * @return array
     */
    public function each(\Closure $closure)
    {
        return $this->crawler->each(function (Crawler $node, $i) use ($closure) {
            return $closure(new static($node), $i);
        });
    }

    /**
     * @param string $attribute
     *
     * @return string
     */
    public function attr($attribute)
    {
        try {
            $value = trim($this->crawler->attr($attribute));

            return 'href' === $attribute ? $this->fillUrl($value) : $value;
        } catch (\InvalidArgumentException $e) {
            return '';
        }
    }

    /**
     * @return string
     */
    public function text()
    {
        try {
            return trim($this->crawler->text());
        } catch (\InvalidArgumentException $e) {
            return '';
        }
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function fillUrl($url)
    {
        $component = parse_url($url);

        return (isset($component['scheme']) ? '' : 'https://www.zhihu.com').$url;
    }
}
