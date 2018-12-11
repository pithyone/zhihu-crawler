<?php

namespace ZhihuCrawler;

class Crawler extends \Symfony\Component\DomCrawler\Crawler
{
    /**
     * @inheritdoc
     */
    public function attr($attribute)
    {
        $value = $this->getParentAttr($attribute);

        return $attribute === 'href' ? $this->fillUrl($value) : $value;
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
     * @param string $url
     * @return string
     */
    private function fillUrl($url)
    {
        $component = parse_url($url);

        return (isset($component['scheme']) ? '' : 'https://www.zhihu.com') . $url;
    }
}
