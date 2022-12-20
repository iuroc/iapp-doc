<?php
require('./config.php');
require('./init.php');
require('./public_fun.php');
/**
 * 删除文章
 */
class Delete_article extends Public_fun
{
    public function __construct()
    {
        $this->get_article_id();
        // 获取手册ID，用于删除文章后返回手册页面
        $this->get_book_id();
        // 验证管理员密码
        $password = $_COOKIE['password'] ?? '';
        if ($password != Config::$admin['password']) {
            header('location: ./login.php');
            die();
        }
        $this->delete_article();
        header('location:./book.php?book_id=' . $this->book_id);
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
