# zhihu-crawler

🕷 轻量级知乎爬虫

## 特性

- 简单易操作，不用管理 Cookie
- 自定义设置输出对象属性，例如只输出答案中全部图片（用途你懂的）
- 记录请求、解析日志，方便 Debug

## 安装

```shell
$ composer require pithyone/zhihu-crawler
```

## 用法

可直接参考 [demo](examples)

> 建议使用命令行运行脚本，因为过程比较耗时

- [初始化](docs/initialize.md)
- [问题](docs/question.md)
- [回答](docs/answer.md)
- [收藏夹](docs/collection.md)

## 常见问题

- 如果日志中出现 `Get data failed` 类似信息，不一定代表抓取失败，还有一种可能就是被抓取属性值为空。

## License

MIT