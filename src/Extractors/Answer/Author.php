<?php

namespace pithyone\zhihu\crawler\Extractors\Answer;

use pithyone\zhihu\crawler\Extractors\Extractor;

class Author implements Extractor
{
    static public function extract($crawler)
    {
        try {
            return $crawler->filter('a[class="author-link"]')->text();
        } catch (\Exception $e) {
            return '';
        }
    }
}
