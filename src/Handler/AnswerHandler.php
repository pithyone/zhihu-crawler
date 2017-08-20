<?php
/**
 * AnswerHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/19
 */

namespace pithyone\zhihu\crawler\Handler;

use Arrayy\Arrayy as A;
use GuzzleHttp\Client;
use QL\QueryList;
use Stringy\Stringy as S;

/**
 * Class AnswerHandler.
 */
class AnswerHandler extends AbstractHandler
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string 问题ID
     */
    protected $questionId;

    /**
     * @var int 页数
     */
    protected $page;

    /**
     * AnswerHandler constructor.
     *
     * @param Client $client
     * @param string $questionId
     * @param int $page
     */
    public function __construct(Client $client, $questionId, $page)
    {
        $this->client ?: $this->client = $client;
        $this->questionId ?: $this->questionId = $questionId;
        $this->page ?: $this->page = $page;
    }

    /**
     * {@inheritdoc}
     */
    protected function page()
    {
        $offset   = ($this->page - 1) * 10;
        $data     = [
            'method' => 'next',
            'params' => json_encode([
                'url_token' => $this->questionId,
                'pagesize'  => 10,
                'offset'    => $offset > 0 ? $offset : 0,
            ]),
        ];
        $response = $this->client->post('/node/QuestionAnswerListV2', ['form_params' => $data]);
        $array    = \GuzzleHttp\json_decode((string)$response->getBody(), true);
        return A::create($array)->get('msg')->implode();
    }

    /**
     * {@inheritdoc}
     */
    protected function rules()
    {
        return [
            'avatar'      => ['img[class^="zm-list-avatar"]', 'src'],
            'author'      => ['a[class="author-link"]', 'text'],
            'author_link' => ['a[class="author-link"]', 'href'],
            'bio'         => ['span[class="bio"]', 'title'],
            'vote'        => ['span[class="count"]', 'text'],
            'images'      => ['div[class^="zm-editable-content"]', 'html'],
            'link'        => ['link[itemprop="url"]', 'href'],
            'comment'     => [
                'a[name="addcomment"]',
                'text',
                '',
                function ($text) {
                    return intval($text);
                },
            ],
            'summary'     => [
                'div[class^="zm-editable-content"]',
                'text',
                '',
                function ($text) {
                    return (string)S::create($text)->substr(0, 350)->collapseWhitespace();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function range()
    {
        return 'div[tabindex="-1"]';
    }

    /**
     * {@inheritdoc}
     */
    public function pick($callback = null)
    {
        return QueryList::Query($this->page(), $this->rules(), $this->range())->getData(
            function ($item) use ($callback) {
                $handler        = new ImageHandler($item['images']);
                $images         = $handler->pick(function ($data) {
                    return $data['image'];
                });
                $item['images'] = A::create($images)->stripEmpty()->values()->toArray();
                return is_callable($callback) ? call_user_func($callback, $item) : $item;
            }
        );
    }
}
