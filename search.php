<?php
require('./include/config.php');
require('./include/init.php');
require('./include/public_fun.php');
/**
 * 搜索页面
 * 
 * @author 欧阳鹏
 * @version 1.0
 */
class Search extends Public_fun
{
}

$search = new Search();
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php require('./include/head.php') ?>
    <title>搜索 - <?php echo Config::$site_title ?></title>
    <meta name="description" content="<?php echo Config::$site_title ?> <?php echo Config::$description ?>">
    <meta name="og:description" content="<?php echo Config::$site_title ?> <?php echo Config::$description ?>">
    <script>
        const PAGE_NAME = 'search' // 页面标识
    </script>
</head>

<body>
    <?php require('./include/nav.php') ?>
    <div class="container">
        <div class="row mb-3">
        </div>
    </div>
    <?php require('./include/footer.php') ?>
</body>

</html>