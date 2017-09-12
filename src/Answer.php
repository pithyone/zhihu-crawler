<?php

namespace pithyone\zhihu\crawler;

class Answer extends Base
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var int
     */
    protected $page = null;

    const MAX_PAGE = 100;  // 抓取最大值为100页

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
     * @param int $page
     *
     * @return $this
     *
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
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function lists($callback = null)
    {
        $max_page = is_null($this->page) || $this->page > self::MAX_PAGE ? self::MAX_PAGE : $this->page;

        $ret = [];
        for ($page = 1; $page <= $max_page; $page++) {
            $params = [
                'url_token' => $this->id,
                'pagesize'  => 10,
                'offset'    => ($page - 1) * 10,
            ];
            $options = [
                'method' => 'next',
                'params' => json_encode($params),
            ];

            $body = $this->http->response('POST', ['/node/QuestionAnswerListV2', $options]);
            $contents = $this->getContents($body);
            if ($contents === false) {
                break;
            }

            $data = $this->query
                ->page($contents)
                ->rules([
                    'avatar'      => ['img[class^="zm-list-avatar"]', 'src'],
                    'author'      => ['a[class="author-link"]', 'text'],
                    'author_link' => ['a[class="author-link"]', 'href'],
                    'bio'         => ['span[class="bio"]', 'title'],
                    'vote'        => [
                        'div[class="zm-item-vote-info"]',
                        'data-votecount',
                        '',
                        function ($text) {
                            return (int) $text;
                        },
                    ],
                    'content'     => ['div[class^="zm-editable-content"]', 'html'],
                    'link'        => ['link[itemprop="url"]', 'href'],
                    'comment'     => [
                        'a[name="addcomment"]',
                        'text',
                        '',
                        function ($text) {
                            return (int) $text;
                        },
                    ],
                    'summary'     => [
                        'div[class^="zm-editable-content"]',
                        'text',
                        '',
                        function ($text) {
                            $text = str_replace(PHP_EOL, '', $text);

                            return trim(mb_substr($text, 0, 350, 'utf-8'));
                        },
                    ],
                ])
                ->range('div[tabindex="-1"]')
                ->callback(function (&$data) use ($callback) {
                    $images = Image::lists($data['content']);
                    $data['images'] = array_values(array_filter($images));

                    unset($data['content']);

                    if (is_callable($callback)) {
                        return call_user_func_array($callback, [$data]);
                    } else {
                        return $data;
                    }
                })->getData();

            $ret = array_merge($ret, $data);
        }

        return $ret;
    }

    /**
     * @param $body
     *
     * @return bool|string
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    private function getContents($body)
    {
        $contents = json_decode($body, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            return false;
        }

        if (!isset($contents['msg']) || empty($contents['msg'])) {
            return false;
        } else {
            return implode('', $contents['msg']);
        }
    }
}
