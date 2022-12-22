<?php
require('./config.php');
require('./init.php');
/**
 * 上传手册
 */
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php include './head.php' ?>
    <title>关于 - <?php echo Config::$site_title ?></title>
    <script>
        const PAGE_NAME = 'about' // 页面标识
    </script>
</head>

<body>
    <?php include './nav.php' ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./" class="text-decoration-none">主页</a></li>
            <li class="breadcrumb-item active">关于</li>
        </ol>
        <div class="h3 mb-3">关于</div>
        <ul>
            <li class="mb-1">Github：<a href="https://github.com/oyps/iapp-doc" target="_blank">https://github.com/oyps/iapp-doc</a></li>
            <li class="mb-1">作者：欧阳鹏</li>
            <li class="mb-1">官网：<a href="https://apee.top" target="_blank">https://apee.top</a></li>
            <li>开发日期：2022年12月19日</li>
        </ul>
    </div>
    <?php require('./footer.php') ?>
</body>

</html>