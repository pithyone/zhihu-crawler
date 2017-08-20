<?php
/**
 * AbstractHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/19
 */

namespace pithyone\zhihu\crawler\Handler;

use QL\QueryList;

/**
 * Class AbstractHandler.
 */
abstract class AbstractHandler
{
    /**
     * 要抓取的网页URL地址或网页源代码
     *
     * @return string
     */
    abstract protected function page();

    /**
     * 采集规则.
     *
     * @link https://doc.querylist.cc/site/index/doc/30
     *
     * @return array
     */
    abstract protected function rules();

    /**
     * 区域选择器.
     *
     * @link http://doc.querylist.cc/site/index/doc/29
     *
     * @return string
     */
    protected function range()
    {
        return '';
    }

    /**
     * 采集.
     *
     * @param callback $callback
     *
     * @return array
     */
    public function pick($callback = null)
    {
        return QueryList::Query($this->page(), $this->rules(), $this->range())->getData($callback);
    }
}
