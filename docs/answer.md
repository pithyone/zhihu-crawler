# 回答

> 可直接参考 [demo](../examples/answer.php)

## 获取实例

```php
use pithyone\zhihu\crawler\Application;

// ...

$app = new Application($config);

$answer = $app->answer;
```

## 设置问题ID

```php
$answer->id($id)
```

## 设置抓取页数

默认抓取全部回答（耗时）

```php
$answer->page($page)
```

## 得到列表

```php
$answer->lists()
```

### 得到列表中某个属性

```php
$answer->lists(function ($data) {
    // ...
})
```

例：获取回答中的全部图片

```php
$answer->lists(function ($data) {
    return $data['images'];
});
```


### 列表结构

```json
[
    {
        "avatar": "https:\/\/pic3.zhimg.com\/v2-fda0f4ac66a1987c1e23f0be2680e502_s.jpg",
        "author": "小野Jen",
        "author_link": "\/people\/li-sha-90-88",
        "bio": "",
        "vote": 1482,
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
