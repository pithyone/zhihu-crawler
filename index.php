<?php

use pithyone\zhihu\crawler\Handler\AnswerHandler;

$answerHandler = new AnswerHandler(58481349, 1);

$answerHandler->pick(function ($item) {
    // 存储操作，保存到数据库...
    return $item['images']; // 输出回答中所有图片
});
