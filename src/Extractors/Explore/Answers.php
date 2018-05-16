<?php

namespace pithyone\zhihu\crawler\Extractors\Explore;

use pithyone\zhihu\crawler\Extractors\Extractor;

class Answers implements Extractor
{
    static public function extract($crawler)
    {
        return $crawler->filter('.feed-item')->each(function ($node) {
            return [
                'title'      => trim($node->filter('.question_link')->text()),
                'link'       => $node->filter('link')->attr('href'),
                'summary'    => Summary::extract($node),
                'vote_count' => $node->filter('.zm-item-vote-info')->attr('data-votecount'),
            ];
        });
    }
}
