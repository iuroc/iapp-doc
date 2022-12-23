# iApp-Doc

> 在线手册管理与写作平台

## 项目信息

- 作者：欧阳鹏
- 开发日期：2022年12月19日
- 官网：https://apee.top
- 关键词：PHP、Bootstrap、伪静态、Cookie、文件上传

## 功能规划

- 代码搜索（标题、全文）
- 文章可编辑，手册可增加文章
- Markdown 默认支持
- 控制台：导入手册、删除手册

## 数据库设计

### 手册（iapp_doc_book）

| 字段名      | 类型     | 描述     |
| ----------- | -------- | -------- |
| id          | int      | 手册ID   |
| create_time | datetime | 创建时间 |
| update_time | datetime | 更新时间 |
| title       | varchar  | 手册标题 |
| intro       | varchar  | 手册介绍 |

### 文章（iapp_doc_article）

| 字段名      | 类型     | 描述     |
| ----------- | -------- | -------- |
| id          | int      | 文章ID   |
| title       | varchar  | 文章标题 |
| content     | text     | 正文内容 |
| update_time | datetime | 更新时间 |
| book_id     | int      | 手册ID   |

## 路由规划

| 伪静态后URL           | 原URL                                | 描述       |
| --------------------- | ------------------------------------ | ---------- |
| /                     | /                                    | 主页       |
| /book_3.html          | /book.php?book_id=3                  | 某手册主页 |
| /article_123.html     | /article.php?article_id=123          | 某文章页面 |
| /search/all/1234.html | /search.php?book_id=all&keyword=1234 | 搜索       |
| /control/upload       | /control/upload.php                  | 上传手册   |

## 待优化

- `document.title` 统一化
- `require` 统一化，`location` 重定向适配伪静态
- 补全关于页的项目简介
- 为了优化 SEO，可以在文章页面追加原文？
- 优化一下文章页面 Markdown 文档的样式，如表格、图片（响应式）等
- Markdown 编辑器支持
- 文章阅读页面，增加上一篇和下一篇链接
- 兼容性问题分析（不同浏览器、服务器、软件版本测试）
- 优化移动端文章编辑器
- 文章章节的排序问题
- Markdown 阅读器的文档大纲显示
- 谷歌收录

## 部署说明

1. 将源代码上传到网站目录
2. 为网站目录设置 777 权限
3. `include/config.php` 可以进行站点配置
4. 如果想要启用数据库导出功能，请允许 PHP 使用 `system` 函数

## 手册文件格式

1. TXT 文本格式
2. 内容格式

    ```
    【文章标题】
    文章内容
    【文章标题】
    文章内容
    ...
    ```

3. 需要将文章内容中的【】符号替换成 `&left;` 和 `&right;`，防止和分隔符 `【】` 冲突

## 官方手册处理流程（正则）

- `】(\s*\n)*` => `】```java\n`
- `(\n\s*)*【` => `\n```【`
- `\\` => `\\\\`

注：直接使用 `bin\官方文档预处理.py` 程序，将官方文档 TXT 文件放到一个文件夹，选择该文件夹即可自动处理