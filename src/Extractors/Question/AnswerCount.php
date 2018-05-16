<?php

namespace pithyone\zhihu\crawler\Extractors\Question;

use pithyone\zhihu\crawler\Extractors\Extractor;

class AnswerCount implements Extractor
{
    static public function extract($crawler)
    {
        return $crawler->filter('meta[itemProp="answerCount"]')->attr('content');
    }
}
