<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Answer;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Answer\Answers;
use Symfony\Component\DomCrawler\Crawler;

class AnswersTest extends TestCase
{
    public function testEmpty()
    {
        $html = '<div></div>';

        $answers = Answers::extract(new Crawler($html));

        $this->assertEmpty($answers);

        $this->assertInternalType('array', $answers);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testException()
    {
        $html = '<div tabindex="-1"></div>';

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
            $this->assertArrayHasKey('author', $answer);
            $this->assertArrayHasKey('author_link', $answer);
            $this->assertArrayHasKey('bio', $answer);
            $this->assertArrayHasKey('vote_count', $answer);
            $this->assertArrayHasKey('images', $answer);
        }
    }

    public function extractProvider()
    {
        return [
            ['<div tabindex="-1"><div class="zm-item-vote-info"></div></div>'],
            ['<div tabindex="-1"><div class="zm-item-vote-info" data-votecount="1234"></div></div>'],
        ];
    }
}
