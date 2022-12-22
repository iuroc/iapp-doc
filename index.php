<?php
require('./config.php');
require('./init.php');
/**
 * 主页
 */
class Index
{
    /**
     * 手册列表
     */
    public array $book_list;
    public function __construct()
    {
        $this->get_book_list();
    }
    public function get_book_list()
    {
        $table = Config::$table['book'];
        $sql = "SELECT * FROM `$table` ORDER BY UNIX_TIMESTAMP(`update_time`) DESC, `id`";
        $result = mysqli_query(Init::$conn, $sql);
        $list = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $this->book_list = $list;
    }
}
$index = new Index();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./head.php') ?>
    <title><?php echo Config::$site_title ?></title>
    <script>
        const PAGE_NAME = 'home' // 页面标识
    </script>
</head>

<body>
    <?php require('./nav.php') ?>
    <div class="container">
        <div class="row mb-3">
            <?php
            foreach ($index->book_list as $book_info) {
                echo '
            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 mb-3">
                <a title="' . strip_tags($book_info['title']) . '" class="justify-content-between card card-body shadow-sm h-100 text-decoration-none" href="' . (Config::$url_static ?
                    'book_' . $book_info['id'] . '.html' :
                    'book.php?book_id=' . $book_info['id'])
                    . '" role="button">
                    <div class="h5 text-truncate">' . $book_info['title'] . '</div>
                    <div class="mb-2 limit-line-4 text-muted text-justify">' . strip_tags(mb_substr($book_info['intro'], 0, 80)) . '</div>
                    <div class="text-muted small">' . $book_info['update_time'] . ' 最后更新</div>
                </a>
            </div>';
            }
            ?>
        </div>
    </div>
    <?php require('./footer.php') ?>
</body>

</html>