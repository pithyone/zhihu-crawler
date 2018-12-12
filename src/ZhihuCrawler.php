<?php

namespace ZhihuCrawler;

use Symfony\Component\DomCrawler\Crawler;

class ZhihuCrawler extends Crawler
{
    /**
     * @param Crawler $crawler
     * @return ZhihuCrawler
     */
    public static function createFromCrawler(Crawler $crawler)
    {
        return new static($crawler->html(), $crawler->getUri(), $crawler->getBaseHref());
    }

    /**
     * @inheritdoc
     */
    public function attr($attribute)
    {
        try {
            $value = trim($this->getParentAttr($attribute));

            return $attribute === 'href' ? $this->fillUrl($value) : $value;
        } catch (\InvalidArgumentException $e) {
            return '';
        }
    }

    /**
     * @inheritdoc
     */
    public function text()
    {
        try {
            return trim($this->getParentText());
        } catch (\InvalidArgumentException $e) {
            return '';
        }
    }

    /**
     * @inheritdoc
     */
    public function each(\Closure $closure)
    {
        $data = array();
        foreach ($this as $i => $node) {
            $data[] = $closure(new static($node), $i);
        }

        return $data;
    }

    /**
     * @param $attribute
     * @return string|null
     */
    protected function getParentAttr($attribute)
    {
        return parent::attr($attribute);
    }

    /**
     * @return string
     */
    protected function getParentText()
    {
        return parent::text();
    }

    /**
     * @param string $url
     * @return string
     */
    private function fillUrl($url)
    {
        $component = parse_url($url);

        return (isset($component['scheme']) ? '' : 'https://www.zhihu.com') . $url;
    }
}
