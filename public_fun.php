<?php

/**
 * 公共方法
 */
class Public_fun
{
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
     * 获取手册信息
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
}
