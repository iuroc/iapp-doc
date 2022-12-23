<?php
require('./include/config.php');
require('./include/init.php');
require('./include/public_fun.php');
/**
 * 删除手册
 */
class Delete_book extends Public_fun
{
    public function __construct()
    {
        $this->must_login();
        $this->get_book_id();
        $this->delete_article();
        $this->delete_book();
        header('location:./');
    }
    /**
     * 删除文章数据（必须先删除文章，再删除手册信息）
     */
    public function delete_article()
    {
        $table = Config::$table['article'];
        $sql = "DELETE FROM `$table` WHERE `book_id` = {$this->book_id}";
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

$delete_book = new Delete_book();
