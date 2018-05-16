<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Question;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Question\Detail;
use Symfony\Component\DomCrawler\Crawler;

class DetailTest extends TestCase
{
    /**
     * @dataProvider extractProvider
     */
    public function testExtract($html, $expected)
    {
        $detail = Detail::extract(new Crawler($html));

        $this->assertEquals($expected, $detail);
    }

    public function extractProvider()
    {
        return [
            ['<div></div>', ''],
            ['<div class="RichText">text</div>', 'text'],
        ];
    }
}
