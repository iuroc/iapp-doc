<?php
require('./include/config.php');
require('./include/init.php');
require('./include/public_fun.php');
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
        $sql = "SELECT * FROM `$table` WHERE `book_id` = {$this->book_id};";
        // $sql = "SELECT * FROM `$table` WHERE `book_id` = {$this->book_id} ORDER BY UNIX_TIMESTAMP(`update_time`) DESC, `id`;";
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
    <?php require('./include/head.php') ?>
    <title><?php echo strip_tags($book->book_title) ?> - <?php echo Config::$site_title ?></title>
    <?php
    $description = $book->parse_value($book->book_title) . ' ' . str_replace("\n", '', $book->parse_value($book->book_info['intro']));
    $description = parse_content_200($description);
    /**
     * 截取前 200 字符
     */
    function parse_content_200($text)
    {
        $text = str_replace("\n", '', htmlspecialchars(strip_tags(mb_substr($text, 0, 200))));
        // 隐藏 Markdown 字符
        $text = preg_replace('/[#[\]!<>*`-]/', '', $text);
        return $text;
    }
    ?>
    <meta name="description" content="<?php echo $description ?>">
    <meta property="og:title" content="<?php echo $book->parse_value($book->book_title) ?> - <?php echo Config::$site_title ?><">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="<?php echo Config::$site_title ?>">
    <meta name="og:description" content="<?php echo $description ?>">
    <script>
        const PAGE_NAME = 'book' // 页面标识
    </script>
</head>

<body>
    <?php require('./include/nav.php') ?>
    <div class="container">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">主页</a></li>
                <li class="breadcrumb-item active"><?php echo strip_tags($book->book_title) ?></li>
            </ol>
        </nav>
        <div class="row">
            <?php
            function parse_content($text)
            {
                $text = strip_tags(mb_substr($text, 0, 120));
                // 隐藏 Markdown 字符
                $text = preg_replace('/[#[\]!<>*`-]/', '', $text);
                return $text;
            }
            foreach ($book->article_list as $article_info) {
                echo '
            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 mb-3">
                <a title="' . strip_tags($article_info['title']) . '"
                    class="justify-content-between card card-body shadow-sm h-100"
                    href="' . $book->get_article_url($article_info['id']) . '" role="button">
                    <div class="h5 text-truncate">' . $article_info['title'] . '</div>
                    <div class="mb-2 limit-line-4 text-muted text-justify">
                        ' . parse_content($article_info['content']) .
                    '</div>
                    <div class="text-muted small">' . $article_info['update_time'] . ' 最后更新</div>
                </a>
            </div>';
            }
            ?>
        </div>
        <?php
        if ($book->has_login) {
            echo '
        <div class="pb-3 mt-3 sticky-bottom">
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
    <?php require('./include/footer.php') ?>
</body>

</html>