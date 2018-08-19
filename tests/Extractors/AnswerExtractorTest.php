<?php

namespace ZhihuCrawler\Tests\Extractors;

use Mockery\MockInterface;
use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Extractors\AnswerExtractor;
use ZhihuCrawler\Tests\TestCase;

class AnswerExtractorTest extends TestCase
{
    /**
     * @var AnswerExtractor
     */
    protected $answerExtractor;

    /**
     * @var MockInterface
     */
    protected $crawler;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->crawler = \Mockery::mock(Crawler::class);

        $this->answerExtractor = new AnswerExtractor($this->crawler);
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testValidateUrl()
    {
        $this->assertEquals('', $this->callMethod($this->answerExtractor, 'validateUrl', ['']));
        $this->assertEquals('https://www.zhihu.com/question/0/answer/0', $this->callMethod($this->answerExtractor, 'validateUrl', ['/question/0/answer/0']));
        $this->assertEquals('https://zhuanlan.zhihu.com/p/0', $this->callMethod($this->answerExtractor, 'validateUrl', ['https://zhuanlan.zhihu.com/p/0']));
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetLinkPath()
    {
        $answerExtractor = \Mockery::mock(AnswerExtractor::class . '[getLink]', [$this->crawler]);

        $answerExtractor->shouldReceive('getLink')
            ->twice()
            ->withNoArgs()
            ->andReturn('https://www.zhihu.com/question/foo/answer/bar');

        $this->assertEquals('foo', $this->callMethod($answerExtractor, 'getLinkPath', ['question']));
        $this->assertEquals('bar', $this->callMethod($answerExtractor, 'getLinkPath', ['answer']));
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetLinkPathException()
    {
        $answerExtractor = \Mockery::mock(AnswerExtractor::class . '[getLink]', [$this->crawler]);

        $answerExtractor->shouldReceive('getLink')
            ->twice()
            ->withNoArgs()
            ->andReturn('https://zhuanlan.zhihu.com/p/foo');

        $this->assertEquals('', $this->callMethod($answerExtractor, 'getLinkPath', ['question']));
        $this->assertEquals('', $this->callMethod($answerExtractor, 'getLinkPath', ['answer']));
    }

    /**
     * @return void
     */
    public function testGetId()
    {
        $answerExtractor = \Mockery::mock(AnswerExtractor::class . '[getLinkPath]', [$this->crawler])->shouldAllowMockingProtectedMethods();

        $answerExtractor->shouldReceive('getLinkPath')
            ->once()
            ->with('answer')
            ->andReturn('12345678');

        $this->assertEquals(12345678, $answerExtractor->getId());
    }

    /**
     * @return void
     */
    public function testGetQuestionId()
    {
        $answerExtractor = \Mockery::mock(AnswerExtractor::class . '[getLinkPath]', [$this->crawler])->shouldAllowMockingProtectedMethods();

        $answerExtractor->shouldReceive('getLinkPath')
            ->once()
            ->with('question')
            ->andReturn('12345678');

        $this->assertEquals(12345678, $answerExtractor->getQuestionId());
    }

    /**
     * @return void
     */
    public function testGetAuthor()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('a[class="author-link"]')
            ->andReturnSelf();

        $this->crawler->shouldReceive('text')
            ->once()
            ->withNoArgs()
            ->andReturn('author');

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertEquals('author', $this->answerExtractor->getAuthor());
    }

    /**
     * @return void
     */
    public function testGetAuthorException()
    {
        $this->crawler->shouldReceive('filter->text')
            ->andThrow(\InvalidArgumentException::class);

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertEquals('', $this->answerExtractor->getAuthor());
    }

    /**
     * @return void
     */
    public function testGetAuthorBio()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('span[class="bio"]')
            ->andReturnSelf();

        $this->crawler->shouldReceive('attr')
            ->once()
            ->with('title')
            ->andReturn('author_bio');

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertEquals('author_bio', $this->answerExtractor->getAuthorBio());
    }

    /**
     * @return void
     */
    public function testGetAuthorBioException()
    {
        $this->crawler->shouldReceive('filter->attr')
            ->andThrow(\InvalidArgumentException::class);

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertEquals('', $this->answerExtractor->getAuthorBio());
    }

    /**
     * @return void
     */
    public function testGetAuthorLink()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('a[class="author-link"]')
            ->andReturnSelf();

        $this->crawler->shouldReceive('attr')
            ->once()
            ->with('href')
            ->andReturn('/author_link');

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertEquals('https://www.zhihu.com/author_link', $this->answerExtractor->getAuthorLink());
    }

    /**
     * @return void
     */
    public function testGetAuthorLinkException()
    {
        $this->crawler->shouldReceive('filter->attr')
            ->andThrow(\InvalidArgumentException::class);

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertEquals('', $this->answerExtractor->getAuthorLink());
    }

    /**
     * @return void
     */
    public function testGetImageList()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('div[class^="zm-editable-content"]')
            ->andReturnSelf();

        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('noscript img')
            ->andReturnSelf();

        $this->crawler->shouldReceive('each')
            ->once()
            ->andReturn(['image']);

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertEquals(['image'], $this->answerExtractor->getImageList());
    }

    /**
     * @return void
     */
    public function testGetSummary()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('.zh-summary')
            ->andReturnSelf();

        $this->crawler->shouldReceive('text')
            ->once()
            ->withNoArgs()
            ->andReturn('显示全部');

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertEquals('', $this->answerExtractor->getSummary());
    }

    /**
     * @return void
     */
    public function testGetLink()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('link')
            ->andReturnSelf();

        $this->crawler->shouldReceive('attr')
            ->once()
            ->with('href')
            ->andReturn('/link');

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertEquals('https://www.zhihu.com/link', $this->answerExtractor->getLink());
    }

    /**
     * @return void
     */
    public function testGetVoteCount()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('.zm-item-vote-info')
            ->andReturnSelf();

        $this->crawler->shouldReceive('attr')
            ->once()
            ->with('data-votecount')
            ->andReturn('0');

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertSame(0, $this->answerExtractor->getVoteCount());
    }

    /**
     * @return void
     */
    public function testGetCreated()
    {
        $this->crawler->shouldReceive('filter')
            ->once()
            ->with('.zm-item-answer')
            ->andReturnSelf();

        $this->crawler->shouldReceive('attr')
            ->once()
            ->with('data-created')
            ->andReturn('0');

        $this->answerExtractor->setCrawler($this->crawler);

        $this->assertSame(0, $this->answerExtractor->getCreated());
    }
}
