<?php
/**
 * CollectionSelector.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/28
 */

namespace pithyone\zhihu\crawler\Selector;

use Stringy\Stringy as S;

/**
 * Class CollectionSelector.
 *
 * @property $title
 * @property $link
 * @property $vote
 * @property $author
 * @property $author_link
 * @property $bio
 * @property $summary
 * @property $comment
 * @property $created
 */
class CollectionSelector extends ListSelector
{
    /**
     * 标题.
     *
     * @return string
     */
    protected function title()
    {
        $str = $this->crawler->filter('h2[class="zm-item-title"]')->text();

        return (string) S::create($str)->collapseWhitespace();
    }

    /**
     * 回答链接.
     *
     * @return null|string
     */
    protected function link()
    {
        return $this->crawler->filter('link')->attr('href');
    }
}
