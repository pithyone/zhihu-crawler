# zhihu-crawler

知乎爬虫

> 此爬虫只做轻量级使用

## 特性

- 简单易操作，不用管理 Cookie
- 自定义设置输出对象属性，例如只输出答案中的所有图片（用途你懂的）
- 记录请求、解析日志，方便 Debug

## 安装

```shell
$ composer require pithyone/zhihu-crawler
```

## 用法

可直接参考 [demo](examples)

> 建议使用命令行运行脚本，因为过程比较耗时

> 默认输出数据格式为数组，下方展示数据为 `json_encode` 后的结果

### 初始化

如果你想了解爬虫的工作机制，或者出现问题无从下手，建议你把 Debug 模式打开。

```php
use pithyone\zhihu\crawler\Application;

$config = [
    'debug' => true,                        // Debug 模式，当值为 true 时，记录请求、解析日志
    'log'   => [
        'file' => './tmp/zhihu-crawler.log' // 日志文件位置，要求绝对路径
    ],
];

$app = new Application($config);
```

### 问题对象

```php
// 得到问题对象实例
$question = $app->question;

// 获取问题对象详细信息
$question->id(26037846)->get();
```

#### 方法

```text
$question->id()     知乎问题ID
```

#### 输出

```json
{
    "title": "身材好是一种怎样的体验？",
    "description": "镜像问题：身材差是一种怎样的体验? - 生活"
}
```

##### 字段解释：

```text
title           标题
description     描述
```

### 回答对象

```php
// 得到回答对象实例
$answer = $app->answer;

// 获取问题回答列表
$answer->id(26037846)->page(1)->lists();
```

#### 方法

```text
$answer->id()       知乎问题ID
$answer->page()     抓取回答页数，不设置此方法则抓取全部回答（耗时）
```

#### 输出

```json
[
    {
        "avatar": "https:\/\/pic3.zhimg.com\/v2-fda0f4ac66a1987c1e23f0be2680e502_s.jpg",
        "author": "小野Jen",
        "author_link": "\/people\/li-sha-90-88",
        "bio": "",
        "vote": "1482",
        "link": "\/question\/26037846\/answer\/127910292",
        "comment": 541,
        "summary": "走在路上回头率非常高，甚至站在原地不动了 看着我走。情侣会一起看着我。去餐厅吃饭会有人把排号的票让给我先进。我身边的朋友说跟我一起走会有压力。甚至要求跟我保持一米的距离站在路边拐弯口，那些司机和后座的人都忍不住扭头盯着我，我姐妹说那些人不好好开车想撞车呀！盯着我看的不是单只有男士，更多的是女人。去健身房都会被误会是私人教练。不是只受男性青睐，更受女性崇拜。经常被人说像明星一样！朋友说: 是行走的春药教练说做了那么多年，换了7个健身房就没见过我这种身材的.大多人数说:是他见过身材最正的,加以强调无数次。微信小视频截图这些大多都在没有内衣和任何胸垫的情况下的状态不穿内衣的情况下身材用照片没办法阐述从头到脚没有整过。那天跟朋友练胸肌。练胸肌为了型好看外，让胸不容易下垂。普通人，只是幸运爸妈给了好底",
        "images": [
            "https:\/\/pic4.zhimg.com\/v2-b3b59c6861d1315a8ca534239d503fe7_b.jpg",
            "https:\/\/pic4.zhimg.com\/v2-75e514199b8d038cb2826002efe1142f_b.jpg",
            "https:\/\/pic1.zhimg.com\/v2-a192c845d7e96b3ade76f1da27a8c358_b.jpg",
            "https:\/\/pic4.zhimg.com\/v2-6132595fffa4693f45d94cd526a19533_b.jpg",
            "https:\/\/pic4.zhimg.com\/v2-2ff497f9992406c47da2810d96abe9f7_b.jpg",
            "https:\/\/pic1.zhimg.com\/v2-a0751d02ee4447ca1079a3b9d49cc3c4_b.jpg",
            "https:\/\/pic1.zhimg.com\/v2-608176deea92d64a459b0005fb89dc88_b.jpg",
            "https:\/\/pic1.zhimg.com\/v2-98f0ba0fb8abde60613f731ab88f0f28_b.jpg",
            "https:\/\/pic4.zhimg.com\/v2-c443bf42e6e7d0235acf077b1056dc3b_b.jpg",
            "https:\/\/pic4.zhimg.com\/v2-3532e3f0dc38bd52bbaa5ffb361e766b_b.jpg",
            "https:\/\/pic4.zhimg.com\/v2-5894044a940df9f4a78ebe21b178ce37_b.jpg",
            "https:\/\/pic2.zhimg.com\/v2-f442ae0df47c4c14ebe4efbb754650c1_b.jpg",
            "https:\/\/pic3.zhimg.com\/v2-8a76cb57306aaaf4ce5468f9b9a0d7f2_b.jpg",
            "https:\/\/pic1.zhimg.com\/v2-5918917bf74f52bae22d0a70d0563820_b.jpg"
        ]
    }
]
```

##### 字段解释：

```text
avatar          作者头像
author          作者昵称
author_link     作者知乎链接
bio             作者个人简介
vote            回答赞同人数
link            回答链接
comment         回答评论数
summary         回答摘要
images          回答中所有图片链接
```

### 收藏夹

```php
// 得到收藏夹实例
$collection = $app->collection;

// 获取收藏夹内容列表
$collection->id(51916382)->page(1)->lists();
```

#### 方法

```text
$collection->id()       设置收藏夹ID
$collection->page()     设置抓取收藏夹页数，默认为1
```

#### 输出

```json
[
    {
        "title": "有马甲线是种怎样的体验？",
        "link": "\/question\/28586345\/answer\/187895265",
        "vote": "467",
        "author": "无敌大猩猩",
        "author_link": "\/people\/sandy-40-57",
        "bio": "胸大活好屁股翘 腿长腰细不黏手 说的都他妈不是我",
        "summary": "\n我也有我也有我也有！！！！我也是拥有马甲线的女人！！！而且我的马甲线只花了我五分钟出来！！！！！下文有教程。先上个图 接下来是教程：1.首先洗干净肚皮表面2.准备阴影和高光3.先用深色阴影画个框4.再用阴影画横线竖线5.然后上高光打量肚皮 注意了，拍…",
        "create_time": "1498188131",
        "comment": 179
    }
]
```

##### 字段解释：

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

## 如何自定义设置输出对象属性❓

只需要在 `->lists()` 方法中设置回调函数，返回你想要的属性即可。

同样，如果你需要进行数据库操作，也在回调函数中进行处理。

> 属性名称请参考上方输出结果（字段解释）

例：输出回答中所有图片链接

```php
$answer->id(26037846)->page(1)->lists(function ($data) {
    return $data['images'];
});
```
