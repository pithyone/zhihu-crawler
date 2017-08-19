<?php

namespace pithyone\zhihu\crawler;

use QL\QueryList;

class Image
{
    /**
     * @param $page
     *
     * @return mixed
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    public static function lists($page)
    {
        return QueryList::Query($page, ['image' => ['img', 'data-actualsrc']])->getData(function ($data) {
            return $data['image'];
        });
    }
}
