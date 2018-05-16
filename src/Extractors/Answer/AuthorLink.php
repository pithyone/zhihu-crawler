<?php

namespace pithyone\zhihu\crawler\Extractors\Answer;

use pithyone\zhihu\crawler\Extractors\Extractor;

class AuthorLink implements Extractor
{
    static public function extract($crawler)
    {
        try {
            return $crawler->filter('a[class="author-link"]')->attr('href');
        } catch (\Exception $e) {
            return '';
        }
    }
}
