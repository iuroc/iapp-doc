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
        $this->if_has_login();
    }
}
$article = new Article();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./head.php') ?>
    <title><?php echo strip_tags($article->article_title) ?> - <?php echo strip_tags($article->book_info['title']) ?> - iApp 手册网</title>
    <script src="https://cdn.staticfile.org/marked/4.2.4/marked.min.js"></script>
    <?php $sub_content = str_replace("\n", '', strip_tags(mb_substr($article->article_info['content'], 0, 200))) ?>
    <meta name="description" content="<?php echo strip_tags($article->article_title) ?> <?php echo strip_tags($sub_content) ?> | <?php echo strip_tags($article->book_info['title']) ?>">
    <meta name="keywords" content="<?php echo strip_tags($article->article_title) ?>, <?php echo strip_tags($article->book_info['title']) ?>">
    <link rel="stylesheet" href="css/prism-default.css">
    <link rel="stylesheet" href="css/article.css">
    <script>
        const PAGE_NAME = 'book' // 页面标识
    </script>
</head>

<body>
    <?php require('./nav.php') ?>
    <div class="container">
        <nav class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./" class="text-decoration-none">主页</a></li>
                <li class="breadcrumb-item"><a href="./book.php?book_id=<?php echo $article->book_info['id'] ?>" class="text-decoration-none"><?php echo strip_tags($article->book_info['title']) ?></a></li>
                <li class="breadcrumb-item active"><?php echo strip_tags($article->article_title) ?></li>
            </ol>
        </nav>
        <div class="h2 mb-3 fw-bold"><?php echo $article->article_title ?></div>
        <div class="text-muted"><?php echo $article->article_info['update_time'] ?> 最后更新</div>
        <hr>
        <div id="content" class="mb-3"></div>
        <?php
        if ($article->has_login) {
            echo '
        <div class="mb-4">
            <a class="btn btn-outline-primary btn-sm me-2" href="edit_article.php?action=edit&article_id=' . $article->article_info['id'] . '">编辑</a>
            <a class="btn btn-outline-danger btn-sm" onclick="delete_article(' . $article->book_info['id'] . ', ' . $article->article_info['id'] . ')">删除</a>
        </div>
        <script>
            function delete_article(id) {
                let url = "' . 'delete_article.php?book_id=' . $article->book_info['id'] . '&article_id=' . $article->article_info['id'] . '";
                if (confirm(\'确定要删除该文章？\')) {
                    location.href = url
                }
            }
        </script>';
        }
        ?>
    </div>
    <script>
        <?php
        function parse_print($text)
        {
            return json_encode(['text' => $text], JSON_UNESCAPED_UNICODE);
        }
        ?>
        let data = <?php echo parse_print($article->article_info['content']) . PHP_EOL ?>
        document.getElementById('content').innerHTML = marked.parse(data.text);
    </script>
    <script src="js/prism.js"></script>
    <script>
        // 手动触发
        Prism.highlightAll()
        let codeEles = document.querySelectorAll('pre code')
        if (codeEles) {
            codeEles.forEach(ele => {
                ele.contentEditable = true
            })
        }
        let tableEles = document.querySelectorAll('#content table')
        if (tableEles) {
            tableEles.forEach(ele => {
                ele.classList.add('table')
                ele.classList.add('table-bordered')
                ele.style.width = 'auto'
                ele.style.maxWidth = '100%'
            })
        }
    </script>
    <?php require('./footer.php') ?>
</body>

</html>