<?php
/**
 * QuestionHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/19
 */

namespace pithyone\zhihu\crawler\Handler;

use pithyone\zhihu\crawler\Selector\QuestionSelector;

/**
 * Class QuestionHandler.
 */
class QuestionHandler extends AbstractHandler
{
    /**
     * @var string
     */
    protected $questionId;

    /**
     * QuestionHandler constructor.
     *
     * @param string $questionId 问题ID
     */
    public function __construct($questionId)
    {
        parent::__construct();
        $this->questionId ?: $this->questionId = $questionId;
    }

    /**
     * {@inheritdoc}
     */
    public function pick($callback = null)
    {
        $crawler = $this->client->request('GET', self::BASE_URI."/question/{$this->questionId}");
        $questionSelector = new QuestionSelector($crawler);

        $item = [
            'title'       => $questionSelector->title,
            'description' => $questionSelector->description,
            'comment'     => $questionSelector->comment,
            'followers'   => $questionSelector->followers,
            'viewed'      => $questionSelector->viewed,
            'answer'      => $questionSelector->answer,
        ];

        return is_callable($callback) ? call_user_func($callback, $item) : $item;
    }
}
