# 收藏夹

> 可直接参考 [demo](../examples/collection.php)

## 获取实例

```php
use pithyone\zhihu\crawler\Application;

// ...

$app = new Application($config);

$collection = $app->collection;
```

## 设置收藏夹ID

```php
$collection->id($id)
```

## 设置抓取页数

默认为1

```php
$collection->page($page)
```

## 得到列表

```php
$collection->lists()
```

### 得到列表中某个属性

```php
$collection->lists(function ($data) {
    // ...
})
```

例：获取回答中的标题

```php
$collection->lists(function ($data) {
    return $data['title'];
});
```


### 列表结构

```json
[
    {
        "title": "有马甲线是种怎样的体验？",
        "link": "\/question\/28586345\/answer\/187895265",
        "vote": 467,
        "author": "无敌大猩猩",
        "author_link": "\/people\/sandy-40-57",
        "bio": "胸大活好屁股翘 腿长腰细不黏手 说的都他妈不是我",
        "summary": "\n我也有我也有我也有！！！！我也是拥有马甲线的女人！！！而且我的马甲线只花了我五分钟出来！！！！！下文有教程。先上个图 接下来是教程：1.首先洗干净肚皮表面2.准备阴影和高光3.先用深色阴影画个框4.再用阴影画横线竖线5.然后上高光打量肚皮 注意了，拍…",
        "create_time": 1498188131,
        "comment": 179
    }
]
```

```text
title           问题标题
link            回答链接
vote            回答赞同人数
author          作者昵称
author_link     作者知乎链接
bio             作者个人简介
summary         回答摘要
comment         回答评论数
```
