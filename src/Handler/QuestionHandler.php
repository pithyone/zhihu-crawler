<?php
/**
 * QuestionHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/19
 */

namespace pithyone\zhihu\crawler\Handler;

use GuzzleHttp\Client;

/**
 * Class QuestionHandler.
 */
class QuestionHandler extends AbstractHandler
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string 问题ID
     */
    protected $questionId;

    /**
     * QuestionHandler constructor.
     *
     * @param Client $client
     * @param string $questionId
     */
    public function __construct(Client $client, $questionId)
    {
        $this->client ?: $this->client = $client;
        $this->questionId ?: $this->questionId = $questionId;
    }

    /**
     * {@inheritdoc}
     */
    protected function page()
    {
        $response = $this->client->get("/question/{$this->questionId}");
        return (string)$response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    protected function rules()
    {
        return [
            'title'       => ['h1[class="QuestionHeader-title"]', 'text'],
            'description' => ['span[class="RichText"]', 'text'],
        ];
    }
}
