<?php

/**
 * 公共方法
 */
class Public_fun
{
    /**
     * 是否已经登录
     */
    public bool $has_login;
    /**
     * 手册ID
     */
    public int $book_id;
    /**
     * 手册标题
     */
    public string $book_title;
    /**
     * 手册信息
     */
    public array $book_info;
    /**
     * 文章列表
     */
    public array $article_list;
    /**
     * 文章标题
     */
    public string $article_title;
    /**
     * 文章ID
     */
    public int $article_id;
    /**
     * 文章信息
     */
    public array $article_info;
    /**
     * 手册名称
     */
    public string $title;
    /**
     * 手册介绍
     */
    public string $intro = '';
    /**
     * 获取手册信息，返回到 `$this->book_info`
     */
    public function get_book_info()
    {
        $table = Config::$table['book'];
        $sql = "SELECT * FROM `$table` WHERE `id` = {$this->book_id};";
        $result = mysqli_query(Init::$conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            die('手册ID错误');
        }
        $data = mysqli_fetch_assoc($result);
        $this->book_info = $data;
        $this->book_title = $data['title'];
    }
    /**
     * 获取 book_id 参数
     */
    public function get_book_id()
    {
        $book_id = $_GET['book_id'] ?? '';
        if ($book_id == '') {
            die('手册ID不能为空');
        }
        $this->book_id = $book_id;
    }
    /**
     * 获取 `title` 参数
     */
    public function get_title()
    {
        $title = $_POST['title'] ?? '';
        if (!$title) {
            preg_match('/^(.*)\..*$/', $this->file['name'], $matches);
            $title = $matches[1] ?? $this->file['name'];
        }
        if (!$title) {
            die('请输入手册标题');
        }
        if (mb_strlen($title) > 255) {
            die('标题过长');
        }
        $this->title = addslashes($title);
    }
    /**
     * 获取 `intro` 参数
     */
    public function get_intro()
    {
        $intro = $_POST['intro'] ?? '';
        if (mb_strlen($intro) > 500) {
            die('介绍文本过长');
        }
        $this->intro = addslashes($intro);
    }
    /**
     * 判断是否已经登录，返回到 `$this->has_login`
     */
    public function if_has_login()
    {
        $password = $_COOKIE['password'] ?? '';
        $this->has_login = $password == Config::$admin['password'];
    }
}
