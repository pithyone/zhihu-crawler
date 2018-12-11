<?php

require __DIR__ . '/../vendor/autoload.php';

$monthly = new \ZhihuCrawler\Monthly();

foreach ($monthly->getAnswerList() as $answer) {
    var_dump($answer->getTitle());
    var_dump($answer->getLink());
    var_dump($answer->getVoteCount());
    var_dump($answer->getAuthor());
    var_dump($answer->getAuthorLink());
    var_dump($answer->getAuthorBio());
    var_dump($answer->getSummary());
    var_dump($answer->getCreated());
}
