<?php

namespace pithyone\zhihu\crawler;


use QL\QueryList;

class Query
{
    /**
     * @var string
     */
    protected $page = '';

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var string
     */
    protected $range = '';

    /**
     * @var string
     */
    protected $outputEncoding = null;

    /**
     * @var callable
     */
    protected $callback = null;

    /**
     * @param string $page
     *
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function page($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param array $rules
     *
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function rules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @param string $range
     *
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function range($range)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * @param string $outputEncoding
     *
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function outputEncoding($outputEncoding)
    {
        $this->outputEncoding = $outputEncoding;

        return $this;
    }

    /**
     * @param callable $callback
     *
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function callback($callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function getData()
    {
        return QueryList::Query($this->page, $this->rules, $this->range, $this->outputEncoding)
            ->getData($this->callback);
    }
}