<?php
require('require.php');
/**
 * 上传手册
 */
class Upload
{
    /**
     * 手册文件
     */
    public array $file;
    /**
     * 手册名称
     */
    public string $title;
    /**
     * 访问类型
     */
    public string $action;
    /**
     * 手册介绍
     */
    public string $intro = '';
    /**
     * 当前脚本相对路径
     */
    public const PATH = '/control/upload.php';
    public function __construct()
    {
        $this->action = $_POST['action'] ?? '';
        if ($this->action == 'submit') {
            // 获取文件数据
            $this->file = $_FILES['file'] ?? null;
            if (!$this->file || $this->file['error'] > 0) {
                die('文件上传失败');
            }
            // 获取手册名称
            $this->title = $_POST['title'] ?? '';
            if (!$this->title) {
                preg_match('/^(.*)\..*$/', $this->file['name'], $matches);
                $this->title = $matches[1] ?? $this->file['name'];
            }
            if (!$this->title) {
                die('请输入手册标题');
            }
            // 判断文件大小是否超出限制
            if ($this->file['size'] > 3e2) {
                die('文件大小不能超过 3 MB');
            }
            $this->intro = $_POST['intro'] ?? '';
        }
    }
}
$upload = new Upload();
if ($upload->action == 'submit') {
    header('location: ' . Upload::PATH);
}
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php include '../head.php' ?>
    <title>上传手册</title>
    <script>
        const PAGE_NAME = 'upload' // 页面标识
        function changeFile() {
            let dom = document.querySelector('#bookFile')
            let files = dom.files
            if (files.length == 0 || files[0].size > 3e6) {
                alert('文件大小不能超过 3 MB')
                dom.value = null
            }
        }
    </script>
</head>

<body>
    <?php include '../nav.php' ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h3 class="mb-3">手册上传</h3>
                    <div class="mb-3">
                        <label for="bookName" class="form-label">手册名称</label>
                        <input type="text" class="form-control" name="title" id="bookName" placeholder="请输入手册名称" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookFile" class="form-label">选择手册文件（<code>.txt</code> 格式）</label>
                        <input type="file" class="form-control" name="file" id="bookFile" accept="text/plain" required onchange="changeFile()">
                    </div>
                    <div class="mb-3">
                        <label for="bookIntro" class="form-label">手册介绍（200 字以内）</label>
                        <textarea class="form-control" name="intro" id="bookIntro" placeholder="这是一本神奇的手册..." required></textarea>
                    </div>
                    <input type="hidden" name="action" value="submit">
                    <input type="submit" class="btn btn-success mb-3" value="提交">
                </form>
            </div>
        </div>
    </div>
</body>

</html>