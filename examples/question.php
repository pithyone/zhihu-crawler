<?php

require __DIR__ . '/../vendor/autoload.php';

use pithyone\zhihu\crawler\Application;

spl_autoload_register(function ($c) {
    @include_once strtr($c, '\\_', '//') . '.php';
});
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . '/src');

$config = [
    'debug' => true,                        // Debug 模式，当值为 true 时，记录请求、解析日志
    'log'   => [
        'file' => './tmp/zhihu-crawler.log' // 日志文件位置，要求绝对路径
    ],
];

$app = new Application($config);

$question = $app->question;

$question->id(26037846)->get();
