# Sitemap 网站地图生成器

给 Typecho 博客生成网站地图的插件。启用后，打开 `网站地址/sitemap.xml` 就能看到整站地图，方便搜索引擎抓取和收录。

> ⚠️ 仅支持 Typecho，暂不支持 WordPress，请勿安装到 WordPress 上。
> WordPress 请用 [阿彦网站地图（WordPress 版）](https://github.com/JUYIKEJI/wordpress-sitemap)（1.0.0 版）。

## 快速上手

1. 下载这个仓库
2. 把插件文件夹放到 `usr/plugins/Sitemap`
3. 在博客后台启用 Sitemap
4. 打开 `网站地址/sitemap.xml`，确认能正常显示

## 地图里有什么

| 内容 | 权重 | 更新频率 |
| --- | --- | --- |
| 首页 | 1.0 | 每天 |
| 已发布页面 | 0.8 | 每周 |
| 已发布文章 | 0.5 | 每月 |

只收录已发布的内容，草稿和未到发布时间的文章不会出现。

## 工作原理

```mermaid
flowchart LR
    A[访问 sitemap.xml] --> B[只取已发布内容] --> C[生成地图] --> D[搜索引擎抓取]
```

地图生成时还会做三件事，让结果更干净：跳过没有路线的无效链接、同一个链接只出现一次、链接中的特殊符号做转义。

## 常见问题

**打不开 sitemap.xml 怎么办？**

先确认插件已启用、文件夹在 `usr/plugins/Sitemap`、地址后面加了 `/sitemap.xml`。都对了还打不开，把看到的提示截图发过来。

**为什么地图里没有草稿？**

这是特意这样做的，只有已发布的内容才会被搜索引擎抓到。

**能用在 WordPress 上吗？**

不能，见顶部提示。

## 反馈

提问题时写清三点：博客系统和版本、插件版本（当前是 1.2.0）、报错提示或截图。目前仓库还没有公开的问题反馈。

## 版本记录

| 版本 | 日期 | 主要变化 |
| --- | --- | --- |
| 1.2.0 | 2026-11-04 | 加首页；跳过无效链接；链接去重和转义；页面每周、文章每月 |
| 1.1.1 | 原版本 | 修改自 hanny 版本，由 @白先生 优化重构 |

原说明参考：主页内容 https://www.baixiaomo360.com/9，演示 https://www.baixiaomo360.com/sitemap.xml

## 相关链接

- [阿彦的主页](https://github.com/JUYIKEJI)
- [阿彦网站地图（WordPress 版）](https://github.com/JUYIKEJI/wordpress-sitemap)（1.0.0 版）

- [Smartideo 复刻版（WordPress 视频插件）](https://github.com/JUYIKEJI/wordpress-smartideo)（1.0.0 版）
