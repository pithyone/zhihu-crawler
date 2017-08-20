<?php
/**
 * MonthlyHotHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/20
 */

namespace pithyone\zhihu\crawler\Handler;

use GuzzleHttp\Client;
use Stringy\Stringy as S;

/**
 * Class MonthlyHotHandler.
 */
class MonthlyHotHandler extends AbstractHandler
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * MonthlyHotHandler constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client ?: $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    protected function page()
    {
        $response = $this->client->get('/explore#monthly-hot');
        return (string)$response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    protected function rules()
    {
        return [
            'title'       => ['a[class="question_link"]', 'text'],
            'link'        => ['a[class="question_link"]', 'href'],
            'vote'        => ['a[class^="zm-item-vote-count"]', 'text'],
            'author'      => ['a[class="author-link"]', 'text'],
            'author_link' => ['a[class="author-link"]', 'href'],
            'bio'         => ['span[class="bio"]', 'title'],
            'create_time' => ['div[class^="zm-item-answer"]', 'data-created'],
            'summary'     => [
                'div[class*="summary"]',
                'text',
                '-a',
                function ($text) {
                    return (string)S::create($text)->collapseWhitespace();
                },
            ],
            'comment'     => [
                'a[name="addcomment"]',
                'text',
                '',
                function ($text) {
                    return intval($text);
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function range()
    {
        return 'div[data-type="monthly"] div[class^="explore-feed"]';
    }
}
