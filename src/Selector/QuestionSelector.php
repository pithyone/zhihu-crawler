<?php
/**
 * QuestionSelector.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/28
 */

namespace pithyone\zhihu\crawler\Selector;

/**
 * Class QuestionSelector.
 *
 * @property $title
 * @property $description
 * @property $comment
 * @property $followers
 * @property $viewed
 * @property $answer
 */
class QuestionSelector extends AbstractSelector
{
    /**
     * 标题
     *
     * @return string
     */
    protected function title()
    {
        return $this->crawler->filter('h1[class="QuestionHeader-title"]')->text();
    }

    /**
     * 描述
     *
     * @return string
     */
    protected function description()
    {
        return $this->crawler->filter('span[class="RichText"]')->text();
    }

    /**
     * 评论
     *
     * @return string
     */
    protected function comment()
    {
        return (int) $this->crawler->filter('div[class="QuestionHeader-Comment"]')->text();
    }

    /**
     * 关注者
     *
     * @return int
     */
    protected function followers()
    {
        return (int) $this->crawler->filter('div[class="NumberBoard-value"]')->first()->text();
    }

    /**
     * 被浏览
     *
     * @return int
     */
    protected function viewed()
    {
        return (int) $this->crawler->filter('div[class="NumberBoard-value"]')->last()->text();
    }

    /**
     * 回答
     *
     * @return int
     */
    protected function answer()
    {
        return (int) $this->crawler->filter('h4[class="List-headerText"]')->text();
    }
}
