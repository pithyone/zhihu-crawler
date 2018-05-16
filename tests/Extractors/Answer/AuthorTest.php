<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Answer;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Answer\Author;
use Symfony\Component\DomCrawler\Crawler;

class AuthorTest extends TestCase
{
    /**
     * @dataProvider extractProvider
     */
    public function testExtract($html, $expected)
    {
        $author = Author::extract(new Crawler($html));

        $this->assertEquals($expected, $author);
    }

    public function extractProvider()
    {
        return [
            ['<a></a>', ''],
            ['<a class="author-link"></a>', ''],
            ['<a class="author-link">text</a>', 'text'],
        ];
    }
}
