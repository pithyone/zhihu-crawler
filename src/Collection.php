<?php

namespace pithyone\zhihu\crawler;


class Collection extends Base
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @param string $id
     *
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param int $page
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
     * @param callable $callback
     *
     * @return array
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function lists($callback = null)
    {
        $ret = [];
        for ($page = 1; $page <= $this->page; $page++) {
            $contents = $this->http->response('GET', ["/collection/{$this->id}", ['page' => $page]]);

            $data = $this->query
                ->page($contents)
                ->rules([
                    'title'       => ['h2[class="zm-item-title"]', 'text'],
                    'link'        => ['link', 'href'],
                    'vote'        => ['a[class^="zm-item-vote-count"]', 'text'],
                    'author'      => ['a[class="author-link"]', 'text'],
                    'author_link' => ['a[class="author-link"]', 'href'],
                    'bio'         => ['span[class="bio"]', 'title'],
                    'summary'     => ['div[class*="summary"]', 'text', '-a'],
                    'create_time' => ['div[class^="zm-item-answer"]', 'data-created'],
                    'comment'     => [
                        'a[name="addcomment"]', 'text', '', function ($text) {
                            return intval($text);
                        }
                    ]
                ])
                ->range('div[class="zu-main-content"] div[class="zm-item"]')
                ->callback($callback)
                ->getData();

            $ret = array_merge($ret, $data);
        }

        return $ret;
    }
}