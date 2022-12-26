<?php

/**
 * 公共方法
 */
class Public_fun
{
    /**
     * 是否是新增文章模式
     */
    public bool $mode_add;
    /**
     * 是否是编辑文章模式
     */
    public bool $mode_edit;
    /**
     * 状态文本，编辑/新增
     */
    public string $status_text;
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
     * 文章内容文本
     */
    public string $content;
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
     * 获取最新一条手册记录的 ID 值
     */
    public function get_new_book_id()
    {
        $table = Config::$table['book'];
        $sql = "SELECT `id` FROM `$table` ORDER BY `id` DESC LIMIT 1;";
        $result = mysqli_query(Init::$conn, $sql);
        $id = mysqli_fetch_assoc($result)['id'];
        return $id;
    }
    /**
     * 创建手册
     */
    public function create_book()
    {
        $table = Config::$table['book'];
        $sql = "INSERT INTO `$table` (`title`, `intro`) VALUES ('{$this->title}', '{$this->intro}')";
        mysqli_query(Init::$conn, $sql);
    }
    /**
     * 获取 `book_id` 参数
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
     * 获取 `article_id` 参数
     */
    public function get_article_id()
    {
        $article_id = $_GET['article_id'] ?? '';
        if ($article_id == '') {
            die('手册ID不能为空');
        }
        $this->article_id = $article_id;
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
     * 获取 `title` 参数
     */
    public function get_content()
    {
        $content = $_POST['content'] ?? '';
        if (!$content) {
            die('请输入文章内容');
        }
        if (mb_strlen($content) > 65535) {
            die('文章过长');
        }
        $this->content = addslashes($content);
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
    /**
     * 获取文章信息
     */
    public function get_article_info()
    {
        $table = Config::$table['article'];
        $sql = "SELECT * FROM `$table` WHERE `id` = {$this->article_id};";
        $result = mysqli_query(Init::$conn, $sql);
        $article_info = mysqli_fetch_assoc($result);
        $this->article_info = $article_info;
        $this->book_id = $article_info['book_id'];
        $this->article_title = $article_info['title'];
    }
    /**
     * 执行 `htmlspecialchars(strip_tags())`
     */
    function parse_value($text)
    {
        return htmlspecialchars(strip_tags($text));
    }
    /**
     * 要求必须登录，否则跳转登录页面
     */
    public function must_login()
    {
        $this->if_has_login();
        if (!$this->has_login) {
            header('location:login.php');
            die();
        }
    }
    /**
     * 获取手册URL，自动处理伪静态
     */
    public function get_book_url(int ...$book_id)
    {
        $book_id = $book_id ? $book_id[0] : $this->book_id;
        $book_url = 'book.php?book_id=' . $book_id;
        $book_url_static = 'book_' . $book_id . '.html';
        return Config::$url_static ? $book_url_static : $book_url;
    }
    /**
     * 获取文章URL，自动处理伪静态
     */
    public function get_article_url(int ...$article_id)
    {
        $article_id = $article_id ? $article_id[0] : $this->article_id;
        $article_url = 'article.php?article_id=' . $article_id;
        $article_url_static = 'article_' . $article_id . '.html';
        return Config::$url_static ? $article_url_static : $article_url;
    }
    /**
     * 生成文章列表 HTML
     * 
     * @param array $article_list 文章列表数据
     * @param array ...$show_book_title (bool) 是否显示文章所属手册标题
     */
    public function make_article_list_html(array $article_list, ...$show_book_title): string
    {
        function parse_title(string $title, $show_book_title)
        {
            $keyword = $show_book_title[1] ?? '';
            $keys = explode('%', $keyword);
            foreach ($keys as $key) {
                $title = str_replace(strtolower($key), '<span class="text-danger">' . $key . '</span>', strtolower($title));
            }
            return $title;
        }
        $html = '';
        foreach ($article_list as $article_info) {
            $html .= '
        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 mb-3">
            <a title="' . strip_tags($article_info['title']) . '"
                class="justify-content-between card card-body shadow-sm h-100"
                href="' . $this->get_article_url($article_info['id']) . '" role="button">
                <div class="h5 text-truncate">' . parse_title($article_info['title'], $show_book_title) . '</div>
                <div class="mb-2 limit-line-4 text-muted text-justify">
                    ' . $this->parse_content($article_info['content']) .
                '</div>
                ' . (($show_book_title[0] ?? null) ? ('<div class="text-primary mb-2">' . $article_info['book_title'] . '</div>') : '') . '
                <div class="text-muted small">' . $article_info['update_time'] . ' 最后更新</div>
            </a>
        </div>';
        }
        return $html;
    }
    /**
     * 去除 HTML 标签后，输出前 120 字符
     */
    public function parse_content($text)
    {
        $text = strip_tags(mb_substr($text, 0, 120));
        // 隐藏 Markdown 字符
        $text = preg_replace('/[#[\]!<>*`-]/', '', $text);
        return $text;
    }
}


// 关于什么时候需要用形参
// 1. 形参不是成员变量
// 2. 函数不需要被多次循环调用