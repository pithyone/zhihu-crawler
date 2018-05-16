<?php

namespace pithyone\zhihu\crawler\tests\Model;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Model\Answer;

class AnswerTest extends TestCase
{
    /**
     * @dataProvider getProvider
     */
    public function testGet($id, $offset)
    {
        $answer = Answer::get($id, $offset);

        $this->assertInternalType('array', $answer);

        $this->assertArrayHasKey('answers', $answer);
    }

    public function getProvider()
    {
        return [
            [0, 0],
            [272059466, 0],
            [272059466, 10000],
        ];
    }
}
