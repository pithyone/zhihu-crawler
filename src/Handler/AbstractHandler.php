<?php
/**
 * AbstractHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/19
 */

namespace pithyone\zhihu\crawler\Handler;

use Goutte\Client;

/**
 * Class AbstractHandler.
 */
abstract class AbstractHandler
{
    const BASE_URI = 'https://www.zhihu.com';

    /**
     * @var Client
     */
    protected $client;

    /**
     * AbstractHandler constructor.
     */
    public function __construct()
    {
        $this->client ?: $this->client = new Client();
    }

    /**
     * 采集.
     *
     * @param callback $callback
     *
     * @return array
     */
    abstract public function pick($callback = null);
}
