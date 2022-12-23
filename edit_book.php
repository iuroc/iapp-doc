<?php
require('./include/config.php');
require('./include/init.php');
require('./include/public_fun.php');
/**
 * 更新手册
 */
class Edit_book extends Public_fun
{
    public function __construct()
    {
        $this->must_login();
        $action = $_GET['action'] ?? '';
        $submit = $_POST['submit'] ?? '';
        if ($action == 'edit') {
            $this->mode_add = false;
            $this->mode_edit = true;
            $this->status_text = '编辑';
            $this->get_book_id();
            $this->get_book_info();
            if ($submit) {
                $this->edit();
                header('location:' . $this->get_book_url());
                die();
            }
        } else {
            $this->mode_add = true;
            $this->mode_edit = false;
            $this->status_text = '新增';
            if ($submit) {
                $this->get_title();
                $this->get_intro();
                $this->create_book();
                $this->book_id = $this->get_new_book_id();
                header('location:' . $this->get_book_url());
                die();
            }
        }
    }
    public function edit()
    {
        $this->get_title();
        $this->get_intro();
        $this->update();
    }
    public function update()
    {
        $table = Config::$table['book'];
        $sql = "UPDATE `$table` SET `title` = '{$this->title}', `intro` = '{$this->intro}', `update_time` = CURRENT_TIMESTAMP WHERE `id` = {$this->book_id};";
        mysqli_query(Init::$conn, $sql);
    }
}
$edit_book = new Edit_book();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./include/head.php') ?>
    <title><?php echo $edit_book->status_text ?>手册信息 - <?php echo Config::$site_title ?></title>
    <script>
        const PAGE_NAME = 'edit_book' // 页面标识
    </script>
</head>

<body>
    <?php require('./include/nav.php') ?>
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-7 col-lg-8 mx-auto">
                <form method="POST">
                    <div class="h4 mb-3"><?php echo $edit_book->status_text ?>手册信息</div>
                    <div class="mb-3">
                        <label for="bookName" class="form-label">手册名称（250字以内）</label>
                        <input type="text" class="form-control" name="title" id="bookName" placeholder="请输入手册名称" value="<?php
                                                                                                                        echo $edit_book->mode_edit ?
                                                                                                                            htmlspecialchars($edit_book->book_title) :
                                                                                                                            '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookIntro" class="form-label">手册介绍（500 字以内）</label>
                        <textarea class="form-control" name="intro" rows="5" id="bookIntro" placeholder="这是一本神奇的手册..." required><?php
                                                                                                                                echo $edit_book->mode_edit ?
                                                                                                                                    htmlspecialchars($edit_book->book_info['intro']) :
                                                                                                                                    '' ?></textarea>
                    </div>
                    <input type="hidden" name="submit" value="1">
                    <button class="btn btn-success mb-3">提交修改</button>
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
    <?php require('./include/footer.php') ?>
</body>

</html>