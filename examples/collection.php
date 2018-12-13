<?php

require __DIR__.'/../vendor/autoload.php';

$collection = new \ZhihuCrawler\Collection('41893350');

var_dump($collection->getTitle());
var_dump($collection->getDetail());

foreach ($collection->getAnswerList() as $answer) {
    var_dump($answer->getTitle());
    var_dump($answer->getLink());
    var_dump($answer->getVoteCount());
    var_dump($answer->getAuthor());
    var_dump($answer->getAuthorLink());
    var_dump($answer->getAuthorBio());
    var_dump($answer->getSummary());
    var_dump($answer->getCreated());
}
