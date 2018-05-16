<?php

namespace pithyone\zhihu\crawler\tests\Model;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Model\Question;

class QuestionTest extends TestCase
{
    public function testFind()
    {
        $question = Question::find(272059466);

        $this->assertInternalType('array', $question);

        $this->assertArrayHasKey('title', $question);
        $this->assertArrayHasKey('detail', $question);
        $this->assertArrayHasKey('answer_count', $question);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testException()
    {
        Question::find(0);
    }
}
