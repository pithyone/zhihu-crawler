<?php
/**
 * AbstractSelector.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/28
 */

namespace pithyone\zhihu\crawler\Selector;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AbstractSelector.
 */
class AbstractSelector
{
    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * AbstractSelector constructor.
     *
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        try {
            return call_user_func([$this, $name]);
        } catch (\Exception $e) {
            return null;
        }
    }
}
