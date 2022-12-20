<?php

/**
 * 手册主页
 */
class Book
{
    public string $book_name;
    /**
     * 手册信息
     */
    public array $book_info;
    /**
     * 文章列表
     */
    public array $article_list;
    public function __construct()
    {
    }
    /**
     * 获取手册信息
     */
    public function get_book_info()
    {
    }
    /**
     * 获取文章列表
     */
    public function get_article_list()
    {
    }
}
$book = new Book();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php include 'head.php' ?>
    <title><?php  ?> - iApp 手册网</title>
    <script>
        const PAGE_NAME = 'book' // 页面标识
    </script>
</head>

<body>
    <?php include 'nav.php' ?>
    <div class="container">
        <div class="h3 mb-3"><?php  ?></div>
        <div class="row">
            <?php  ?>
        </div>
    </div>
</body>

</html>