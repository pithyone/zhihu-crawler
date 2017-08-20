<?php
/**
 * index.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/19
 */

require __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Client;
use pithyone\zhihu\crawler\Handler\AnswerHandler;
use pithyone\zhihu\crawler\Handler\CollectionHandler;
use pithyone\zhihu\crawler\Handler\MonthlyHotHandler;
use pithyone\zhihu\crawler\Handler\QuestionHandler;
use pithyone\zhihu\crawler\ZhLite;

spl_autoload_register(function ($c) {
    @include_once strtr($c, '\\_', '//').'.php';
});
set_include_path(get_include_path().PATH_SEPARATOR.dirname(__DIR__).'/src');

$config = [
    'debug' => true,
    'log'   => [
        'file' => __DIR__.'/../tmp/crawler.log',
    ],
];

$client = new Client([
    'base_uri' => 'https://www.zhihu.com',
    'timeout'  => 5.0,
]);

$zhLite = new ZhLite($config);

$zhLite->setHandler(new QuestionHandler($client, 58481349));
$zhLite->pick();

$zhLite->setHandler(new MonthlyHotHandler($client));
$zhLite->pick();

for ($i = 1; $i < 3; $i++) {
    $zhLite->setHandler(new CollectionHandler($client, 38324051, $i));
    $zhLite->pick();
}

for ($i = 1; $i < 3; $i++) {
    $zhLite->setHandler(new AnswerHandler($client, 58481349, $i));
    $zhLite->pick(function ($item) {
        return $item['images'];
    });
}
