<?php

namespace ZhihuCrawler;

class Collection extends AbstractExtractor
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     *
     * @throws NotFoundException
     */
    public function __construct($id)
    {
        $this->id = $id;

        parent::__construct();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->crawler->filter('#zh-fav-head-title')->text();
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return $this->crawler->filter('#zh-fav-head-description')->text();
    }

    /**
     * @param int $page
     *
     * @return string
     */
    protected function getRequestUri($page)
    {
        return "https://www.zhihu.com/collection/{$this->id}?page={$page}";
    }

    /**
     * @return string
     */
    protected function getAnswerListSelector()
    {
        return 'div[class="zm-item"]';
    }

    /**
     * @return string
     */
    protected function getAnswerTitleSelector()
    {
        return '.zm-item-title';
    }
}
