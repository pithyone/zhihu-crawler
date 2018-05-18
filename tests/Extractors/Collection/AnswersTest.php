<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Collection;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Collection\Answers;
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
        }
    }

    public function exceptionProvider()
    {
        return [
            ['<div class="zm-item"><div class="zh-summary"></div></div>'],
            ['<div class="zm-item"><div class="zh-summary"></div><link></div>'],
            ['<div class="zm-item"><div class="zh-summary"></div><div class="zm-item-title"></div></div>'],
        ];
    }

    public function extractProvider()
    {
        return [
            ['<div class="zm-item"><div class="zh-summary"></div><div class="zm-item-title"></div><link></div>'],
            ['<div class="zm-item"><div class="zh-summary"></div><div class="zm-item-title">text</div><link></div>'],
            ['<div class="zm-item"><div class="zh-summary"></div><div class="zm-item-title"></div><link href=""></div>'],
            ['<div class="zm-item"><div class="zh-summary"></div><div class="zm-item-title">text</div><link href=""></div>'],
        ];
    }
}
