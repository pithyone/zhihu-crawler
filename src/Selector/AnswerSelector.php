<?php
/**
 * AnswerSelector.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/28
 */

namespace pithyone\zhihu\crawler\Selector;

use Arrayy\Arrayy as A;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AnswerSelector.
 *
 * @property $link
 * @property $avatar
 * @property $author
 * @property $author_link
 * @property $bio
 * @property $vote
 * @property $images
 * @property $comment
 */
class AnswerSelector extends ListSelector
{
    /**
     * 头像.
     *
     * @return null|string
     */
    protected function avatar()
    {
        return $this->crawler->filter('img[class^="zm-list-avatar"]')->attr('src');
    }

    /**
     * 图片.
     *
     * @return array
     */
    protected function images()
    {
        $array = $this->crawler
            ->filter('div[class^="zm-editable-content"]')
            ->filter('img')
            ->each(function (Crawler $node) {
                return $node->attr('data-actualsrc');
            });

        return A::create($array)->stripEmpty()->values()->toArray();
    }

    /**
     * 回答链接.
     *
     * @return null|string
     */
    protected function link()
    {
        return $this->crawler->filter('link[itemprop="url"]')->attr('href');
    }
}
