<?php

namespace ZhihuCrawler\Tests;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\AnswerInterface;
use ZhihuCrawler\CrawlerDecorator;
use ZhihuCrawler\Question;

class QuestionTest extends TestCase
{
    private $crawler;

    protected function setUp()
    {
        parent::setUp();

        $this->crawler = $this->createCompatibleMock(CrawlerDecorator::class);
    }

    protected function createQuestion()
    {
        $client = $this->createClient();
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo('https://www.zhihu.com/question/id'))->willReturn($this->createCompatibleMock(Crawler::class));

        $stub = $this->getMockBuilder(Question::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createCrawler'])
            ->getMockForAbstractClass();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->once())->method('createCrawler')->willReturn($this->crawler);

        $stub->__construct('id');

        return $stub;
    }

    public function testGetTitle()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('.QuestionHeader-title'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('title');

        $question = $this->createQuestion();

        $this->assertEquals('title', $question->getTitle());
    }

    public function testGetDetail()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('.QuestionHeader-detail span'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('text')->willReturn('detail');

        $question = $this->createQuestion();

        $this->assertEquals('detail', $question->getDetail());
    }

    public function testGetAnswerCount()
    {
        $this->crawler->expects($this->once())->method('filter')->with($this->equalTo('meta[itemProp="answerCount"]'))->willReturnSelf();
        $this->crawler->expects($this->once())->method('attr')->with($this->equalTo('content'))->willReturn('123456789');

        $question = $this->createQuestion();

        $this->assertSame(123456789, $question->getAnswerCount());
    }

    public function testGetAnswerList()
    {
        $response = $this->createCompatibleMock(ResponseInterface::class);
        $response->expects($this->once())->method('getBody')->willReturn('{"msg":["foo","bar"]}');

        $guzzle = $this->createCompatibleMock(\GuzzleHttp\Client::class);
        $guzzle->expects($this->once())->method($this->anything())->with('post', $this->equalTo(['https://www.zhihu.com/node/QuestionAnswerListV2', ['form_params' => ['method' => 'next', 'params' => '{"url_token":"id","pagesize":10,"offset":0}']]]))->willReturn($response);

        $client = $this->createClient();
        $client->expects($this->once())->method('request')->with($this->equalTo('GET'), $this->equalTo('https://www.zhihu.com/question/id'))->willReturn($this->createCompatibleMock(Crawler::class));
        $client->expects($this->once())->method('getClient')->willReturn($guzzle);

        $stub = $this->getMockBuilder(Question::class)
            ->disableOriginalConstructor()
            ->setMethods(['createClient', 'createAnswer', 'getTitle'])
            ->getMock();

        $stub->expects($this->once())->method('createClient')->willReturn($client);
        $stub->expects($this->once())->method('getTitle')->willReturn('title');

        $stub->__construct('id');

        foreach ($stub->getAnswerList() as $answer) {
            $this->assertInstanceOf(AnswerInterface::class, $answer);
        }
    }
}
