<?php
/**
 * MonthlyHotHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/20
 */

namespace pithyone\zhihu\crawler\Handler;

use pithyone\zhihu\crawler\Selector\MonthlyHotSelector;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class MonthlyHotHandler.
 */
class MonthlyHotHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     */
    public function pick($callback = null)
    {
        $crawler = $this->client->request('GET', self::BASE_URI.'/explore#monthly-hot');

        return $crawler
            ->filter('div[data-type="monthly"] div[class^="explore-feed"]')
            ->each(function (Crawler $node) use ($callback) {
                $monthlyHotSelector = new MonthlyHotSelector($node);

                $item = [
                    'title'       => $monthlyHotSelector->title,
                    'link'        => $monthlyHotSelector->link,
                    'vote'        => $monthlyHotSelector->vote,
                    'author'      => $monthlyHotSelector->author,
                    'author_link' => $monthlyHotSelector->author_link,
                    'bio'         => $monthlyHotSelector->bio,
                    'summary'     => $monthlyHotSelector->summary,
                    'comment'     => $monthlyHotSelector->comment,
                    'created'     => $monthlyHotSelector->created,
                ];

                return is_callable($callback) ? call_user_func($callback, $item) : $item;
            });
    }
}
