<?php
require('./config.php');
require('./init.php');
/**
 * 管理员登录页面
 */
class Login
{
    /**是否已经登录 */
    public bool $has_login;
    public function __construct()
    {
        $action = $_POST['action'] ?? '';
        if ($action == 'login') {
            $password = $_POST['password'] ?? '';
        } else {
            $password = $_COOKIE['password'] ?? '';
        }
        $this->has_login = $password == Config::$admin['password'];
        setcookie('password', $password, time() + 3600 * 24 * 365, '/');
        if ($action == 'login') {
            header('location:./login.php');
            die();
        }
    }
}

$login = new Login();
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./head.php') ?>
    <title>管理员</title>
    <script>
        const PAGE_NAME = 'login' // 页面标识
    </script>
</head>

<body>
    <?php require('./nav.php') ?>
    <div class="container">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./" class="text-decoration-none">主页</a></li>
                <li class="breadcrumb-item active">管理员</li>
            </ol>
        </nav>
        <?php if ($login->has_login) {
            echo '
        <div class="mb-3">
            <a class="btn btn-success me-2" href="upload.php">上传手册</a>
            <a class="btn btn-primary me-2" href="edit_book.php?action=add">新建手册</a>
            <a class="btn btn-warning me-2" href="output.php">导出数据库</a>
            <a class="btn btn-danger" href="logout.php">退出登录</a>
        </div>';
        } else {
            echo '
        <div class="row">
            <div class="col-xxl-3 col-xl-4 col-lg-5 mx-auto">
                <div class="h4 text-center mb-3">管理员登录</div>
                <form method="POST">
                    <div class="input-group mb-3">
                        <input type="text" name="password" class="form-control border-primary" placeholder="请输入管理员密码" onfocus="this.type=\'password\'">
                        <input type="hidden" name="action" value="login">
                        <button class="btn btn-primary">登录</button>
                    </div>
                </form>
            </div>
        </div>';
        }
        ?>
    </div>
    <?php require('./footer.php') ?>
</body>

</html>