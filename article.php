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
        $this->get_article_id();
        $this->get_article_info();
        $this->get_book_info();
    }
    public function get_article_id()
    {
        $article_id = $_GET['article_id'] ?? '';
        if ($article_id == '') {
            die('手册ID不能为空');
        }
        $this->article_id = $article_id;
    }
    public function get_article_info()
    {
        $table = Config::$table['article'];
        $sql = "SELECT * FROM `$table` WHERE `id` = {$this->article_id};";
        $result = mysqli_query(Init::$conn, $sql);
        $article_info = mysqli_fetch_assoc($result);
        $this->article_info = $article_info;
        $this->book_id = $article_info['book_id'];
        $this->article_title = $article_info['title'];
    }
}
$article = new Article();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./head.php') ?>
    <title><?php echo $article->article_title ?> - iApp 手册网</title>
    <script src="https://cdn.staticfile.org/marked/4.2.4/marked.min.js"></script>
    <meta name="description" content="<?php echo str_replace("\n", '', htmlentities(mb_substr($article->article_info['content'], 0, 200))) ?>">
    <link rel="stylesheet" href="css/prism.css">
    <script>
        const PAGE_NAME = 'book' // 页面标识
    </script>
</head>

<body>
    <?php require('./nav.php') ?>
    <div class="container">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./" class="text-decoration-none">主页</a></li>
                <li class="breadcrumb-item"><a href="./book.php?book_id=<?php echo $article->book_info['id'] ?>" class="text-decoration-none"><?php echo $article->book_info['title'] ?></a></li>
                <li class="breadcrumb-item active"><?php echo $article->article_title ?></li>
            </ol>
        </nav>
        <h4 class="mb-3"><?php echo $article->article_title ?></h4>
        <div id="content" class="mb-3"></div>
        <div class="mb-4">
            <a class="btn btn-outline-primary btn-sm me-2" href="edit.php?id=<?php echo $article->article_info['id'] ?>">编辑</a>
            <button class="btn btn-outline-success btn-sm me-2">复制</button>
            <a class="btn btn-outline-danger btn-sm" href="delete.php?id=<?php echo $article->article_info['id'] ?>">删除</a>
        </div>
    </div>
    <script>
        <?php
        function parse_print($text)
        {
            $text = htmlentities($text);
            return json_encode(['text' => $text]);
        }
        ?>
        let data = <?php echo parse_print($article->article_info['content']) . PHP_EOL ?>
        document.getElementById('content').innerHTML = marked.parse(data.text);
    </script>
    <script src="js/prism.js"></script>
</body>

</html>