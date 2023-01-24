<?php
require('./include/config.php');
require('./include/init.php');
require('./include/public_fun.php');
/**
 * 搜索页面
 * 
 * @author 欧阳鹏
 * @version 1.0
 */
class Search extends Public_fun
{
    /**
     * 搜索关键词
     */
    public string $keyword;
    /**
     * 初始关键字（未被处理）
     */
    public string $keyword_first;
    /**
     * 搜索结果
     */
    public array $result = [];
    /**
     * 已经被搜索的ID列表
     */
    public array $ids = [];
    public function __construct()
    {
        $this->get_keyword();
        $this->search_title();
        $this->search_content();
    }
    /**
     * 获取参数 `keyword`
     */
    public function get_keyword()
    {
        $this->keyword = $_POST['keyword'] ?? $_GET['keyword'] ?? '';
        $this->keyword_first = $this->keyword;
        $this->keyword = trim($this->keyword);
        $this->keyword = preg_replace('/\s+/', '%', $this->keyword);
        $this->keyword = addslashes($this->keyword);
        if (!$this->keyword) {
            header('location: ./');
            die();
        }
    }
    /**
     * 标题搜索，优先级最高
     */
    public function search_title()
    {
        $table = Config::$table['article'];
        $table_2 = Config::$table['book'];
        $sql = "SELECT article.*, book.`title` AS `book_title` FROM `$table` AS article, `$table_2` AS book WHERE CONCAT(book.`title`, article.`title`) LIKE '%{$this->keyword}%' AND article.`book_id` = book.`id`;";
        $result = mysqli_query(Init::$conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            array_push($this->ids, $id);
            array_push($this->result, $row);
        }
    }

    /**
     * 搜索正文，优先级小于标题搜索
     */
    public function search_content()
    {
        $table = Config::$table['article'];
        $table_2 = Config::$table['book'];
        $sql = "SELECT article.*, book.`title` AS `book_title` FROM `$table` AS article, `$table_2` AS book WHERE article.`content` LIKE '%{$this->keyword}%' AND article.`book_id` = book.`id`;";
        $result = mysqli_query(Init::$conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            // 判断没有被匹配过
            if (!in_array($id, $this->ids)) {
                array_push($this->ids, $id);
                array_push($this->result, $row);
            }
        }
    }
}

$search = new Search();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./include/head.php') ?>
    <title>搜索结果 - <?php echo $search->keyword_first ?> - <?php echo Config::$site_title ?></title>
    <meta name="description" content="<?php echo Config::$site_title ?> <?php echo Config::$description ?>">
    <meta name="og:description" content="<?php echo Config::$site_title ?> <?php echo Config::$description ?>">
    <script>
        const PAGE_NAME = 'search' // 页面标识
    </script>
</head>

<body>
    <?php require('./include/nav.php') ?>
    <script>
        let keyword = <?php echo json_encode($search->keyword_first) ?>;
        document.querySelector('nav [name="keyword"]').value = keyword
    </script>
    <div class="container">
        <div class="row mb-3">
            <?php
            if (count($search->result) == 0) {
                echo '<div class="lead">暂无搜索结果</div>';
            } else {
                echo $search->make_article_list_html($search->result, true, $search->keyword);
            }
            ?>
        </div>
    </div>

    <?php require('./include/footer.php') ?>
</body>

</html>