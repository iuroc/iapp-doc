<?php
require('./include/config.php');
require('./include/init.php');
require('./include/public_fun.php');
/**
 * 删除文章
 */
class Delete_article extends Public_fun
{
    public function __construct()
    {
        $this->must_login();
        $this->get_article_id();
        // 获取手册ID，用于删除文章后返回手册页面
        $this->get_book_id();
        $this->delete_article();
        header('location:' . $this->get_book_url());
    }
    /**
     * 删除文章数据（必须先删除文章，再删除手册信息）
     */
    public function delete_article()
    {
        $table = Config::$table['article'];
        $sql = "DELETE FROM `$table` WHERE `id` = {$this->article_id}";
        mysqli_query(Init::$conn, $sql);
    }
    /**
     * 删除手册信息
     */
    public function delete_book()
    {
        $table = Config::$table['book'];
        $sql = "DELETE FROM `$table` WHERE `id` = {$this->book_id}";
        mysqli_query(Init::$conn, $sql);
    }
}

$delete_article = new Delete_article();
