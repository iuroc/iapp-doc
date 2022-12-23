<?php
require('./include/config.php');
require('./include/init.php');
require('./include/public_fun.php');
require('./include/Parsedown.php');
/**
 * 文章页面
 */
class Article extends Public_fun
{
    /**
     * 上一篇文章数据
     */
    public array $last_article;
    /**
     * 下一篇文章数据
     */
    public array $next_article;
    public function __construct()
    {
        $this->get_article_id();
        $this->get_article_info();
        $this->last_article = $this->get_last_next_article(true);
        $this->next_article = $this->get_last_next_article(false);
        $this->get_book_info();
        $this->if_has_login();
    }
    /**
     * 获取上一篇和下一篇
     * @param bool $is_last 上一篇：true，下一篇：false
     */
    public function get_last_next_article(bool $is_last)
    {
        $table = Config::$table['article'];
        $s = $is_last ? '<' : '>';
        $order = $is_last ? 'ORDER BY `id` DESC' : '';
        $sql = "SELECT * FROM `$table` WHERE `id` $s {$this->article_id} AND `book_id` = '{$this->book_id}' $order LIMIT 1;";
        $result = mysqli_query(Init::$conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            return [];
        }
        $data = mysqli_fetch_assoc($result);
        return $data;
    }
}
$article = new Article();
/**
 * 截取前 200 字符
 */
function parse_content($text)
{
    $text = str_replace("\n", '', htmlspecialchars(strip_tags(mb_substr($text, 0, 200))));
    // 隐藏 Markdown 字符
    $text = preg_replace('/[#[\]!<>*`-]/', '', $text);
    return $text;
}

?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./include/head.php') ?>
    <?php
    $title = $article->parse_value($article->article_title) . ' - ' . $article->parse_value($article->book_info['title']) . ' - ' . Config::$site_title;
    $sub_content = parse_content($article->article_info['content']);
    $description = $article->parse_value($article->article_title) . ' ' . $sub_content . ' | ' . $article->parse_value($article->book_info['title']);
    ?>
    <title><?php echo $title ?></title>
    <script src="https://cdn.staticfile.org/marked/4.2.4/marked.min.js"></script>
    <?php  ?>
    <meta name="description" content="<?php echo $description ?>">
    <meta property="og:title" content="<?php echo $title ?>">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="<?php echo Config::$site_title ?>">
    <meta name="og:description" content="<?php echo $description ?>">
    <link rel="stylesheet" href="css/prism-default.css">
    <link rel="stylesheet" href="css/article.css">
    <script>
        const PAGE_NAME = 'book' // 页面标识
    </script>
</head>

<body>
    <?php require('./include/nav.php') ?>
    <div class="container">
        <nav class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">主页</a></li>
                <li class="breadcrumb-item">
                    <a href="<?php echo $article->get_book_url() ?>">
                        <?php echo strip_tags($article->book_info['title']) ?>
                    </a>
                </li>
                <li class="breadcrumb-item active"><?php echo strip_tags($article->article_title) ?></li>
            </ol>
        </nav>
        <div class="h2 mb-3 fw-bold text-success"><?php echo htmlspecialchars($article->article_title) ?></div>
        <div class="text-muted"><?php echo $article->article_info['update_time'] ?> 最后更新</div>
        <hr>
        <div id="content" class="mb-4">
            <?php
            $Parsedown = new Parsedown();
            echo $Parsedown->text($article->article_info['content']);
            ?>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?php
                if ($article->last_article) {
                    $last_url = $article->get_article_url($article->last_article['id']);
                } else {
                    $last_url = $article->get_book_url();
                }
                ?>
                <a class="card mb-3 card-body" role="button" href="<?php echo $last_url ?>">
                    上一篇：<?php echo strip_tags($article->last_article['title'] ?? '没有更多了'); ?>
                </a>
            </div>
            <div class="col-md-6">
                <?php
                if ($article->next_article) {
                    $next_url = $article->get_article_url($article->next_article['id']);
                } else {
                    $next_url = $article->get_book_url();
                }
                ?>
                <a class="card mb-3 card-body" role="button" href="<?php echo $next_url ?>">
                    下一篇：<?php echo strip_tags($article->next_article['title'] ?? '没有更多了'); ?>
                </a>
            </div>
        </div>
        <?php
        if ($article->has_login) {
            echo '
        <div class="pb-3 mt-3 sticky-bottom">
            <a class="btn btn-primary btn-sm me-2" href="edit_article.php?action=edit&article_id=' . $article->article_info['id'] . '">编辑文章</a>
            <a class="btn btn-danger btn-sm" onclick="delete_article(' . $article->book_info['id'] . ', ' . $article->article_info['id'] . ')">删除文章</a>
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
    <?php require('./include/footer.php') ?>
</body>

</html>