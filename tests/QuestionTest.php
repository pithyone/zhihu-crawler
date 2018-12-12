<?php

namespace ZhihuCrawler\Tests;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Question;

class QuestionTest extends TestCase
{
    private $crawler;

    protected function setUp()
    {
        parent::setUp();

        $this->crawler = $this->createMockCopy(Crawler::class);
    }

    public function testGetTitle()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('.QuestionHeader-title'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('title');

        $question = $this->createQuestion($this->crawler);

        $this->assertEquals('title', $question->getTitle());
    }

    public function testGetDetail()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('.QuestionHeader-detail span'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('detail');

        $question = $this->createQuestion($this->crawler);

        $this->assertEquals('detail', $question->getDetail());
    }

    public function testGetAnswerList()
    {
        $response = $this->createMockCopy(ResponseInterface::class);
        $response->expects($this->once())->method('getBody')->willReturn('{"msg":["foo","bar"]}');

        $guzzle = $this->createMockCopy(\GuzzleHttp\Client::class);
        $guzzle->expects($this->once())->method($this->anything())->with('post', $this->equalTo(['https://www.zhihu.com/node/QuestionAnswerListV2', ['form_params' => ['method' => 'next', 'params' => '{"url_token":"id","pagesize":10,"offset":0}']]]))->willReturn($response);

        $client = $this->getClient();
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo('https://www.zhihu.com/question/id'))->willReturn($this->crawler);
        $client->expects($this->once())->method('getClient')->willReturn($guzzle);

        $stub = $this->getMockBuilder(Question::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createAnswer', 'getTitle'])
            ->getMock();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->once())->method('getTitle')->willReturn('title');
        $stub->expects($this->exactly(2))->method('createAnswer')->withConsecutive([$this->equalTo('foo'), $this->equalTo('title')], [$this->equalTo('bar'), $this->equalTo('title')]);

        $stub->__construct('id');

        foreach ($stub->getAnswerList() as $answer) {
            //
        }
    }
}
