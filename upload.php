<?php
require('./config.php');
require('./init.php');
require('./public_fun.php');
/**
 * 上传手册
 */
class Upload extends Public_fun
{
    /**
     * 手册文件
     */
    public array $file;
    
    /**
     * 访问类型
     */
    public string $action;
    
    /**
     * 手册内容
     */
    public string $text;
    /**
     * 当前脚本相对路径
     */
    public const PATH = '/upload.php';
    public function __construct()
    {
        $this->action = $_POST['action'] ?? '';
        if ($this->action == 'submit') {
            $this->submit();
            header('location: ./');
            die();
        }
    }
    /**
     * 提交事件
     */
    public function submit()
    {
        // 验证管理员密码
        $password = $_COOKIE['password'] ?? '';
        if ($password != Config::$admin['password']) {
            header('location: ./login.php');
            die();
        }
        // 获取文件数据
        $this->file = $_FILES['file'] ?? null;
        if (!$this->file || $this->file['error'] > 0) {
            die('文件上传失败');
        }
        // 获取手册名称
        $this->get_title();
        // 判断文件大小是否超出限制
        if ($this->file['size'] > 3e6) {
            die('文件大小不能超过 3 MB');
        }
        $this->get_intro();
        $this->read_file();
        $this->create_book();
        $this->create_article();
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
     * 创建文章
     */
    public function create_article()
    {
        $list = explode('【', $this->text);
        $book_id = $this->get_new_book_id();
        $table = Config::$table['article'];
        for ($x = 1; $x < count($list); $x++) {
            $item = explode('】', $list[$x]);
            $title = addslashes($item[0]);
            $content = addslashes($item[1]);
            $sql = "INSERT INTO `$table` (`title`, `content`, `book_id`) VALUES ('$title', '$content', '$book_id');";
            mysqli_query(Init::$conn, $sql);
        }
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
     * 读取手册文本文件
     */
    public function read_file()
    {
        $file_path = 'book_' . str_shuffle(time()) . '.txt';
        move_uploaded_file($this->file['tmp_name'], $file_path);
        $text = file_get_contents($file_path);
        unlink($file_path);
        $this->text = $text;
    }
}
new Upload();
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./head.php') ?>
    <title>上传手册</title>
    <script>
        const PAGE_NAME = 'upload' // 页面标识
        function changeFile() {
            let dom = document.querySelector('#bookFile')
            let files = dom.files
            if (files.length != 0 & files[0].size > 3e6) {
                alert('文件大小不能超过 3 MB')
                dom.value = null
            }
        }
    </script>
</head>

<body>
    <?php require('./nav.php') ?>
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-7 col-lg-8 mx-auto">
                <form method="POST" enctype="multipart/form-data">
                    <h4 class="mb-3">手册上传</h4>
                    <div class="mb-3">
                        <label for="bookName" class="form-label">手册名称（250字以内）</label>
                        <input type="text" class="form-control" name="title" id="bookName" placeholder="请输入手册名称" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookFile" class="form-label">选择手册文件</label>
                        <input type="file" class="form-control" name="file" id="bookFile" accept="text/plain" required onchange="changeFile()">
                        <div class="form-text">文件格式要求为 txt 格式，编码要求为 UTF-8</div>
                    </div>
                    <div class="mb-3">
                        <label for="bookIntro" class="form-label">手册介绍（500 字以内）</label>
                        <textarea class="form-control" name="intro" rows="5" id="bookIntro" placeholder="这是一本神奇的手册..." required></textarea>
                    </div>
                    <input type="hidden" name="action" value="submit">
                    <input type="submit" class="btn btn-success" value="提交">
                </form>
            </div>
        </div>
    </div>
    <script>
        function limitInputNum(element, num) {
            element.addEventListener('keyup', function(event) {
                if (element.value.length >= num) {
                    element.value = element.value.substr(0, num)
                }
            })
        }
        let introDom = document.getElementById('bookIntro')
        let nameDom = document.getElementById('bookName')
        limitInputNum(nameDom, 250)
        limitInputNum(introDom, 500)
    </script>
    <?php require('./footer.php') ?>
</body>

</html>