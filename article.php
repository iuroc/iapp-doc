<?php
require('./config.php');
require('./init.php');
require('./public_fun.php');
/**
 * 文章页面
 */
class Article extends Public_fun
{
    public function __construct()
    {
    }
    public function get_article_id()
    {
        $article_id = $_GET['article_id'] ?? '';
        if ($article_id == '') {
            die('手册ID不能为空');
        }
        $this->article_id = $article_id;
    }
}
$article = new Article();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./head.php') ?>
    <title><?php echo $article->article_title ?> - iApp 手册网</title>
    <script>
        const PAGE_NAME = 'book' // 页面标识
    </script>
</head>

<body>
    <?php require('./nav.php') ?>
    <div class="container">
        <div class="h4 mb-3"><?php echo $article->article_title ?></div>
    </div>
</body>

</html>