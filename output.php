<?php
require('./config.php');
require('./init.php');
require('./public_fun.php');
/**
 * 导出数据库
 */
class Output extends Public_fun
{
    public function __construct()
    {
        if (!file_exists('sql_output')) {
            mkdir('sql_output');
        }
        $this->must_login();
        $this->output_table(Config::$table['book']);
        $this->output_table(Config::$table['article']);
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

new Output();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./head.php') ?>
    <title>导出数据库 - <?php echo Config::$site_title ?></title>
    <script>
        const PAGE_NAME = 'home' // 页面标识
    </script>
</head>

<body>
    <?php require('./nav.php') ?>
    <div class="container">
        <a class="btn btn-primary me-2" href="sql_output/<?php echo Config::$table['book'] ?>.sql">手册数据</a>
        <a class="btn btn-success" href="sql_output/<?php echo Config::$table['article'] ?>.sql">文章数据</a>
    </div>
    <?php require('./footer.php') ?>
</body>

</html>