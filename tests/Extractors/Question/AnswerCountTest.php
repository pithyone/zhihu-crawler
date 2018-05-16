<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Question;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Question\AnswerCount;
use Symfony\Component\DomCrawler\Crawler;

class AnswerCountTest extends TestCase
{
    /**
     * @dataProvider exceptionProvider
     * @expectedException \InvalidArgumentException
     */
    public function testException($html)
    {
        AnswerCount::extract(new Crawler($html));
    }

    /**
     * @dataProvider extractProvider
     */
    public function testExtract($html, $expected)
    {
        $answer_count = AnswerCount::extract(new Crawler($html));

        $this->assertEquals($expected, $answer_count);
    }

    public function exceptionProvider()
    {
        return [
            ['<div></div>'],
            ['<div><meta></div>'],
        ];
    }

    public function extractProvider()
    {
        return [
            ['<div><meta itemProp="answerCount"></div>', ''],
            ['<div><meta itemProp="answerCount" content="content"></div>', 'content'],
        ];
    }
}
