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
    <title><?php echo $article->article_title ?> - iApp 手册网</title>
    <script src="https://cdn.staticfile.org/marked/4.2.4/marked.min.js"></script>
    <meta name="description" content="<?php echo htmlentities($article->article_title) ?> <?php echo str_replace("\n", '', htmlentities(mb_substr($article->article_info['content'], 0, 200))) ?> | <?php echo $article->book_info['title'] ?>">
    <meta name="keywords" content="<?php echo htmlentities($article->article_title) ?>, <?php echo $article->book_info['title'] ?>">
    <link rel="stylesheet" href="css/prism.css">
    <style>
        pre[class*=language-] {
            cursor: text;
            outline: none;
            border-radius: 10px;
        }

        pre[class*=language-] code {
            outline: none;
            display: block;
        }

        .language-css .token.string,
        .style .token.string,
        .token.entity,
        .token.operator,
        .token.url {
            background: none;
        }
    </style>
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
        <div class="text-muted"><?php echo $article->article_info['update_time'] ?> 最后更新</div>
        <hr>
        <div id="content" class="mb-3"></div>
        <?php
        if ($article->has_login) {
            echo '
        <div class="mb-4">
            <a class="btn btn-outline-primary btn-sm me-2" href="edit_article.php?action=edit&article_id=' . $article->article_info['id'] . '">编辑</a>
            <button class="btn btn-outline-success btn-sm me-2">复制</button>
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
            // $text = htmlentities($text);
            return json_encode(['text' => $text], JSON_UNESCAPED_UNICODE);
        }
        ?>
        let data = <?php echo parse_print($article->article_info['content']) . PHP_EOL ?>
        document.getElementById('content').innerHTML = marked.parse(data.text);
    </script>
    <script src="js/prism.js"></script>
    <script>
        setTimeout(() => {
            let codeEles = document.querySelectorAll('pre[class*=language-] code')
            if (codeEles) {
                codeEles.forEach(ele => {
                    ele.contentEditable = true
                })
            }

        }, 100);
    </script>
    <?php require('./footer.php') ?>
</body>

</html>