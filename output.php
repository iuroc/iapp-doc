<?php
require('./include/config.php');
require('./include/init.php');
require('./include/public_fun.php');
/**
 * 导出数据库
 */
class Output extends Public_fun
{
    /**
     * 指令类型
     */
    public string $action;
    public function __construct()
    {
        $this->must_login();
        $this->action = $_GET['action'] ?? '';
        if ($this->action == 'output') {
            if (!file_exists('sql_output')) {
                mkdir('sql_output');
            }
            $this->output_table(Config::$table['book']);
            $this->output_table(Config::$table['article']);
            header('location:output.php?action=success');
            die();
        } else if ($this->action == '' && file_exists('sql_output/' . Config::$table['book'] . '.sql') && file_exists('sql_output/' . Config::$table['article'] . '.sql')) {
            // 检查数据库文件是否存在
            $this->action = 'exists';
        }
    }
    /**
     * 导出数据表
     */
    public function output_table($table_name)
    {
        $username = Config::$mysql['user'];
        $database = Config::$mysql['db'];
        $password = Config::$mysql['pass'];
        $command = "mysqldump -u $username --password=$password $database $table_name > sql_output/$table_name.sql";
        system($command);
    }
}

$output = new Output();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./include/head.php') ?>
    <title>导出数据库 - <?php echo Config::$site_title ?></title>
    <script>
        const PAGE_NAME = 'home' // 页面标识
    </script>
</head>

<body>
    <?php require('./include/nav.php') ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">主页</a></li>
            <li class="breadcrumb-item"><a href="./login.php">管理员</a></li>
            <li class="breadcrumb-item active">导出数据库</li>
        </ol>
        <?php
        if ($output->action == 'success') {
            echo '<div class="h5 text-success mb-3">导出成功！</div>';
        }
        if ($output->action == 'output' || $output->action == 'success' || $output->action == 'exists') {
            echo '
        <a class="btn btn-primary me-2 mb-3" href="sql_output/' . Config::$table['book'] . '.sql">手册数据</a>
        <a class="btn btn-success me-2 mb-3" href="sql_output/' . Config::$table['article'] . '.sql">文章数据</a>
        <a class="btn btn-secondary mb-3" href="?action=output">重新导出</a>';
        } else {
            echo '
        <a class="btn btn-primary" href="?action=output">开始导出</a>';
        }
        ?>
    </div>
    <?php require('./include/footer.php') ?>
</body>

</html>