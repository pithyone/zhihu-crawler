<?php

namespace ZhihuCrawler;

class Monthly extends AbstractExtractor
{
    /**
     * @param int $page
     * @return string
     */
    protected function getRequestUri($page)
    {
        $params = urlencode('{"offset":' . (($page - 1) * 5) . ',"type":"month"}');

        return 'https://www.zhihu.com/node/ExploreAnswerListV2?params=' . $params;
    }

    /**
     * @return string
     */
    protected function getAnswerListSelector()
    {
        return '.feed-item';
    }

    /**
     * @return string
     */
    protected function getAnswerTitleSelector()
    {
        return '.question_link';
    }
}
