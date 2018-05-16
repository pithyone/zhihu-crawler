<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Answer;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Answer\AuthorLink;
use Symfony\Component\DomCrawler\Crawler;

class AuthorLinkTest extends TestCase
{
    /**
     * @dataProvider extractProvider
     */
    public function testExtract($html, $expected)
    {
        $author = AuthorLink::extract(new Crawler($html));

        $this->assertEquals($expected, $author);
    }

    public function extractProvider()
    {
        return [
            ['<a></a>', ''],
            ['<a class="author-link"></a>', ''],
            ['<a class="author-link" href="://"></a>', '://'],
        ];
    }
}
