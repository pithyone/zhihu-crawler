<?php
/**
 * CollectionHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/19
 */

namespace pithyone\zhihu\crawler\Handler;

use GuzzleHttp\Client;
use Stringy\Stringy as S;

/**
 * Class CollectionHandler.
 */
class CollectionHandler extends AbstractHandler
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string 收藏夹ID
     */
    protected $collectionId;

    /**
     * @var int 页数
     */
    protected $page;

    /**
     * CollectionHandler constructor.
     *
     * @param Client $client
     * @param $collectionId
     * @param $page
     */
    public function __construct(Client $client, $collectionId, $page)
    {
        $this->client ?: $this->client = $client;
        $this->collectionId ?: $this->collectionId = $collectionId;
        $this->page ?: $this->page = $page;
    }

    /**
     * {@inheritdoc}
     */
    protected function page()
    {
        $response = $this->client->get("/collection/{$this->collectionId}", ['query' => "page={$this->page}"]);

        return (string) $response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    protected function rules()
    {
        return [
            'title'       => ['h2[class="zm-item-title"]', 'text'],
            'link'        => ['link', 'href'],
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
                    return (string) S::create($text)->collapseWhitespace();
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
        return 'div[class="zu-main-content"] div[class="zm-item"]';
    }
}
