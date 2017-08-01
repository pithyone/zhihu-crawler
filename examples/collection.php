<?php

require __DIR__ . '/../vendor/autoload.php';

use pithyone\zhihu\crawler\Application;

spl_autoload_register(function ($c) {
    @include_once strtr($c, '\\_', '//') . '.php';
});
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . '/src');

$config = [
    /**
     * Debug 模式，当值为 true 时，记录请求、解析日志
     */
    'debug' => true,

    /**
     * 日志文件存储位置
     */
    'log'   => [
        'file' => __DIR__ . '/../tmp/zhihu-crawler.log'
    ],
];

$app = new Application($config);
$collection = $app->collection;

$collection->id(51916382)->page(1)->lists();

$titles = [];
$collection->id(51916382)->page(5)->lists(function ($data) use (&$titles) {
    array_push($titles, $data['title']);
});
file_put_contents(__DIR__ . "/../tmp/51916382.json", json_encode($titles, JSON_UNESCAPED_UNICODE));
