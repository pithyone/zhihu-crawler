<?php
/**
 * CollectionHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/19
 */

namespace pithyone\zhihu\crawler\Handler;

use pithyone\zhihu\crawler\Selector\CollectionSelector;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class CollectionHandler.
 */
class CollectionHandler extends AbstractHandler
{
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
     * @param string $collectionId
     * @param int    $page
     */
    public function __construct($collectionId, $page = 1)
    {
        parent::__construct();
        $this->collectionId ?: $this->collectionId = $collectionId;
        $this->page ?: $this->page = $page;
    }

    /**
     * {@inheritdoc}
     */
    public function pick($callback = null)
    {
        $crawler = $this->client->request(
            'GET',
            self::BASE_URI."/collection/{$this->collectionId}?page={$this->page}"
        );

        return $crawler
            ->filter('div[class="zu-main-content"] div[class="zm-item"]')
            ->each(function (Crawler $node) use ($callback) {
                $collectionSelector = new CollectionSelector($node);

                $item = [
                    'title'       => $collectionSelector->title,
                    'link'        => $collectionSelector->link,
                    'vote'        => $collectionSelector->vote,
                    'author'      => $collectionSelector->author,
                    'author_link' => $collectionSelector->author_link,
                    'bio'         => $collectionSelector->bio,
                    'summary'     => $collectionSelector->summary,
                    'comment'     => $collectionSelector->comment,
                    'created'     => $collectionSelector->created,
                ];

                return is_callable($callback) ? call_user_func($callback, $item) : $item;
            });
    }
}
