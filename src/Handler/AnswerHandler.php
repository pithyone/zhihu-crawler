<?php
/**
 * AnswerHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/19
 */

namespace pithyone\zhihu\crawler\Handler;

use Arrayy\Arrayy as A;
use GuzzleHttp\Client;
use pithyone\zhihu\crawler\Selector\AnswerSelector;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AnswerHandler.
 */
class AnswerHandler extends AbstractHandler
{
    /**
     * @var string 问题ID
     */
    protected $questionId;

    /**
     * @var int 页数
     */
    protected $page;

    /**
     * AnswerHandler constructor.
     *
     * @param string $questionId
     * @param int    $page
     */
    public function __construct($questionId, $page = 1)
    {
        parent::__construct();
        $this->questionId ?: $this->questionId = $questionId;
        $this->page ?: $this->page = $page;
    }

    /**
     * {@inheritdoc}
     */
    public function pick($callback = null)
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent($this->content());

        return $crawler
            ->filter('div[tabindex="-1"]')
            ->each(function (Crawler $node) use ($callback) {
                $answerSelector = new AnswerSelector($node);

                $item = [
                    'avatar'      => $answerSelector->avatar,
                    'author'      => $answerSelector->author,
                    'author_link' => $answerSelector->author_link,
                    'bio'         => $answerSelector->bio,
                    'vote'        => $answerSelector->vote,
                    'images'      => $answerSelector->images,
                    'comment'     => $answerSelector->comment,
                ];

                return is_callable($callback) ? call_user_func($callback, $item) : $item;
            });
    }

    /**
     * @return mixed
     */
    protected function content()
    {
        $parameters = [
            'method' => 'next',
            'params' => json_encode([
                'url_token' => $this->questionId,
                'pagesize'  => 10,
                'offset'    => ($this->page - 1) * 10,
            ]),
        ];

        $client = new Client();
        $response = $client->post(self::BASE_URI.'/node/QuestionAnswerListV2', ['form_params' => $parameters]);
        $array = \GuzzleHttp\json_decode((string) $response->getBody(), true);

        return A::create($array)->get('msg')->implode();
    }
}
