<?php
require('./include/config.php');
require('./include/init.php');
/**
 * 上传手册
 */
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php include './include/head.php' ?>
    <title>关于 - <?php echo Config::$site_title ?></title>
    <script>
        const PAGE_NAME = 'about' // 页面标识
    </script>
</head>

<body>
    <?php include './include/nav.php' ?>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">主页</a></li>
            <li class="breadcrumb-item active">关于</li>
        </ol>
        <div class="h3 mb-3">关于</div>
        <p>这是一个专注于分享 iApp 开发技术的网站，由热爱 iApp 的开发者创建。</p>
        <p>iApp 是一代程序员的青春，我们缅怀，也在不断前行。</p>
        <p>本站长期收集优质教程文档，欢迎您通过下方的邮箱向本站投稿。</p>
        <ul class="mb-4">
            <li class="mb-1">投稿、反馈邮箱：<a href="mailto:m@apee.top">m@apee.top</a></li>
            <li class="mb-1">站长的 Github：<a href="https://github.com/oyps" target="_blank">欧阳鹏（oyps）</a></li>
            <li class="mb-1">站长的工作室：<a href="https://apee.top" target="_blank">https://apee.top</a></li>
        </ul>
    </div>
    <?php require('./include/footer.php') ?>
</body>

</html>