<?php
/**
 * ListSelector.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/28
 */

namespace pithyone\zhihu\crawler\Selector;

use Stringy\Stringy as S;

/**
 * Class ListSelector.
 */
class ListSelector extends AbstractSelector
{
    /**
     * 赞同
     *
     * @return string
     */
    protected function vote()
    {
        return $this->crawler->filter('a[class^="zm-item-vote-count"]')->text();
    }

    /**
     * 作者
     *
     * @return string
     */
    protected function author()
    {
        return $this->crawler->filter('a[class="author-link"]')->text();
    }

    /**
     * 作者链接
     *
     * @return null|string
     */
    protected function author_link()
    {
        return $this->crawler->filter('a[class="author-link"]')->attr('href');
    }

    /**
     * 作者一句话介绍
     *
     * @return null|string
     */
    protected function bio()
    {
        return $this->crawler->filter('span[class="bio"]')->attr('title');
    }

    /**
     * 摘要
     *
     * @return string
     */
    protected function summary()
    {
        $str = $this->crawler->filter('div[class*="summary"]')->text();

        return (string) S::create($str)->replace('显示全部', '')->collapseWhitespace();
    }

    /**
     * 评论
     *
     * @return int
     */
    protected function comment()
    {
        return (int) $this->crawler->filter('a[name="addcomment"]')->text();
    }

    /**
     * 回答时间
     *
     * @return int
     */
    protected function created()
    {
        return (int) $this->crawler->filter('div[class^="zm-item-answer"]')->attr('data-created');
    }
}
