# iApp-Doc

> 在线文章写作与手册管理平台

## 项目信息

- 开发日期：2022年12月19日
- 官网：https://apee.top
- 站点地址：http://iapp.apee.top
- 关键词：PHP、Bootstrap、伪静态、Cookie、文件上传、Markdown

## 功能规划

- 代码搜索（标题 + 全文）
- 编辑文章
- 新增文章
- 删除文章
- Markdown 支持
- 新增手册
- 导入手册
- 编辑手册
- 删除手册
- 导出数据库
- 管理员登录

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

## 伪静态设置

| 伪静态后URL       | 原URL                       | 描述       |
| ----------------- | --------------------------- | ---------- |
| /book_3.html      | /book.php?book_id=3         | 某手册主页 |
| /article_123.html | /article.php?article_id=123 | 某文章页面 |

### Ngnix

```
rewrite ^/book_(\d+).html$ /book.php?book_id=$1 break;
rewrite ^/article_(\d+).html$ /article.php?article_id=$1 break;
rewrite ^/sitemap2.xml /sitemap.php?format=xml break;
rewrite ^/sitemap.xml /sitemap.php?format=xml break;
```

### Apache

注意：

```bash
RewriteEngine on
# RewriteBase 这个值类似 HTML 的 base 标签值，如果部署二级目录，填写 /path，如果是根目录，则填 /
RewriteBase /
# RewriteRule 正则需要以 .htaccess 文件所在目录为根目录，后者是正常的 HTML 相对路径
RewriteRule ^book_(\d+).html$ book.php?book_id=$1
RewriteRule ^article_(\d+).html$ article.php?article_id=$1
RewriteRule ^sitemap.xml sitemap.php?format=xml
RewriteRule ^sitemap2.xml sitemap.php?format=xml
```

## 部署说明

1. 下载项目源代码，解压到网站目录，或者直接在网站目录执行下面的命令

    ```bash
    git clone https://github.com/oyps/iapp-doc.git
    ```

2. 为网站目录设置 `777` 权限
3. 打开 `include/config.php`
   1. 修改数据库账号和密码，也可以进行其他站点配置
   2. 如果需要支持二级目录，请设置 `$site_path`
   3. 默认支持伪静态，如果需要关闭，请将 `$url_static` 设置为 `false`
4. 如果想要启用数据库导出功能，请允许 PHP 使用 `system` 函数
5. 请按照 [伪静态设置](#伪静态设置) 配置伪静态

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

## iApp 官方手册处理流程（正则）

注：本规则专门用于 iApp 官方提供的帮助文档处理，其他情况无需理会。

直接使用 `bin\官方文档预处理.py` 程序，将官方文档 TXT 文件放到一个文件夹，选择该文件夹即可自动处理。

- `】(\s*\n)*` => `】```java\n`
- `(\n\s*)*【` => `\n```【`


## 使用到的开源项目

- [Ace 代码编辑器](https://github.com/ajaxorg/ace)
- [github-markdown-css](https://github.com/sindresorhus/github-markdown-css)
- [PrismJS 代码高亮](https://prismjs.com)