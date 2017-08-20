<?php
/**
 * ZhLite.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/20
 */

namespace pithyone\zhihu\crawler;

use Arrayy\Arrayy as A;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use pithyone\zhihu\crawler\Handler\AbstractHandler;
use QL\QueryList;

/**
 * Class ZhLite.
 *
 * @method pick($callback = null)
 */
class ZhLite
{
    /**
     * @var AbstractHandler
     */
    protected $handler;

    /**
     * @var A
     */
    protected $config;

    /**
     * ZhLite constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config ?: $this->config = A::create($config);
        $this->initializeLogger();
    }

    /**
     * 初始化日志
     */
    private function initializeLogger()
    {
        if (!$this->config->get('debug')) {
            QueryList::setLog(new NullHandler());
        } elseif ($handler = $this->config->get('log.handler') instanceof HandlerInterface) {
            QueryList::setLog($handler);
        } elseif ($logFile = $this->config->get('log.file')) {
            QueryList::setLog(new StreamHandler($logFile));
        }
    }

    /**
     * @param AbstractHandler $handler
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
    }


    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->handler, $name], $arguments);
    }
}
