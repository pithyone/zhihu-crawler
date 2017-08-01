# 初始化

如果你想了解爬虫的工作机制，或者出现问题无从下手，建议你把 Debug 模式打开。

```php
<?php

use pithyone\zhihu\crawler\Application;

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
```
