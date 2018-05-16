<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Answer;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Answer\Bio;
use Symfony\Component\DomCrawler\Crawler;

class BioTest extends TestCase
{
    /**
     * @dataProvider extractProvider
     */
    public function testExtract($html, $expected)
    {
        $author = Bio::extract(new Crawler($html));

        $this->assertEquals($expected, $author);
    }

    public function extractProvider()
    {
        return [
            ['<span></span>', ''],
            ['<span class="bio"></span>', ''],
            ['<span class="bio" title="title"></span>', 'title'],
        ];
    }
}
