<?php

namespace pithyone\zhihu\crawler\Extractors\Collection;

use pithyone\zhihu\crawler\Extractors\Extractor;

class Answers implements Extractor
{
    static public function extract($crawler)
    {
        return $crawler->filter('div[class="zm-item"]')->each(function ($node) {
            return [
                'title'   => $node->filter('.zm-item-title')->text(),
                'link'    => $node->filter('link')->attr('href'),
                'summary' => Summary::extract($node),
            ];
        });
    }
}
