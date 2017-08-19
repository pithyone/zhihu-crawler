<?php

namespace pithyone\zhihu\crawler;

class Question extends Base
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @param string $id
     *
     * @return $this
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function get()
    {
        $contents = $this->http->response('GET', ["/question/{$this->id}"]);

        $data = $this->query
            ->page($contents)
            ->rules([
                'title'       => ['h1[class="QuestionHeader-title"]', 'text'],
                'description' => ['span[class="RichText"]', 'text'],
            ])
            ->getData();

        return current($data);
    }
}
