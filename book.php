<?php
require('./config.php');
require('./init.php');
require('./public_fun.php');
/**
 * 手册主页
 */
class Book extends Public_fun
{

    public function __construct()
    {
        $this->get_book_id();
        $this->get_book_info();
        $this->get_article_list();
        $this->if_has_login();
    }

    /**
     * 获取文章列表，返回到 `$this->article_list`
     */
    public function get_article_list()
    {
        $table = Config::$table['article'];
        $sql = "SELECT * FROM `$table` WHERE `book_id` = {$this->book_id} ORDER BY UNIX_TIMESTAMP(`update_time`) DESC;";
        $result = mysqli_query(Init::$conn, $sql);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $this->article_list = $data;
    }
}
$book = new Book();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./head.php') ?>
    <title><?php echo $book->book_title ?> - iApp 手册网</title>
    <meta name="description" content="<?php echo str_replace("\n", '', htmlentities($book->book_info['intro'])) ?>">
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
                <li class="breadcrumb-item active"><?php echo $book->book_title ?></li>
            </ol>
        </nav>
        <div class="row">
            <?php
            foreach ($book->article_list as $article_info) {
                echo '
            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 mb-3">
                <a title="' . htmlentities($article_info['title']) . '" class="justify-content-between card card-body shadow-sm h-100 text-decoration-none" href="article.php?article_id=' . $article_info['id'] . '" role="button">
                    <div class="h5 text-truncate">' . htmlentities($article_info['title']) . '</div>
                    <div class="mb-2 limit-line-4 text-muted text-justify">' . htmlentities(mb_substr($article_info['content'], 0, 120)) . '</div>
                    <div class="text-muted small">' . $article_info['update_time'] . ' 最后更新</div>
                </a>
            </div>';
            }
            ?>
        </div>
        <?php
        if ($book->has_login) {
            echo '
        <div class="pb-3 sticky-bottom">
            <a class="btn btn-sm btn-primary me-2" href="edit_book.php?action=edit&book_id=' . $book->book_info['id'] . '">编辑手册</a>
            <a class="btn btn-sm btn-success me-2" href="edit_article.php?action=add&book_id=' . $book->book_info['id'] . '">新增文章</a>
            <button class="btn btn-sm btn-danger" onclick="delete_book(' . $book->book_info['id'] . ')">删除手册</button>
        </div>
        <script>
            function delete_book(id) {
                let url = "' . 'delete_book.php?book_id=' . $book->book_info['id'] . '";
                if (confirm(\'确定要删除该手册？\')) {
                    location.href = url
                }
            }
        </script>';
        }
        ?>
    </div>
    <?php require('./footer.php') ?>
</body>

</html>