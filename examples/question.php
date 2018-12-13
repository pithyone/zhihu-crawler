<?php

require __DIR__.'/../vendor/autoload.php';

$question = new \ZhihuCrawler\Question('290917836');

var_dump($question->getTitle());
var_dump($question->getDetail());
var_dump($question->getAnswerCount());

foreach ($question->getAnswerList() as $answer) {
    var_dump($answer->getTitle());
    var_dump($answer->getLink());
    var_dump($answer->getVoteCount());
    var_dump($answer->getAuthor());
    var_dump($answer->getAuthorLink());
    var_dump($answer->getAuthorBio());
    var_dump($answer->getSummary());
    var_dump($answer->getCreated());
}
