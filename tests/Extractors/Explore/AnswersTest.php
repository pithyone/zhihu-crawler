<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Explore;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Explore\Answers;
use Symfony\Component\DomCrawler\Crawler;

class AnswersTest extends TestCase
{
    public function testEmpty()
    {
        $html = '<div><div class="zh-summary"></div></div>';

        $answers = Answers::extract(new Crawler($html));

        $this->assertEmpty($answers);

        $this->assertInternalType('array', $answers);
    }

    /**
     * @dataProvider exceptionProvider
     * @expectedException \InvalidArgumentException
     */
    public function testException($html)
    {
        Answers::extract(new Crawler($html));
    }

    /**
     * @dataProvider extractProvider
     */
    public function testExtract($html)
    {
        $answers = Answers::extract(new Crawler($html));

        $this->assertInternalType('array', $answers);

        foreach ($answers as $answer) {
            $this->assertArrayHasKey('title', $answer);
            $this->assertArrayHasKey('link', $answer);
            $this->assertArrayHasKey('summary', $answer);
            $this->assertArrayHasKey('vote_count', $answer);
        }
    }

    public function exceptionProvider()
    {
        return [
            ['<div class="feed-item"><div class="zh-summary"></div></div>'],
            ['<div class="feed-item"><div class="zh-summary"></div><div class="question_link"></div></div>'],
            ['<div class="feed-item"><div class="zh-summary"></div><div class="question_link"></div><link></div>'],
        ];
    }

    public function extractProvider()
    {
        return [
            ['<div class="feed-item"><div class="zh-summary"></div><div class="question_link"></div><link><div class="zm-item-vote-info"></div></div>'],
            ['<div class="feed-item"><div class="zh-summary"></div><div class="question_link"></div><link href=""><div class="zm-item-vote-info"></div></div>'],
            ['<div class="feed-item"><div class="zh-summary"></div><div class="question_link"></div><link href=""><div class="zm-item-vote-info" data-votecount=""></div></div>'],
        ];
    }
}
