<?php

/**
 * 退出登录
 */
setcookie('password', '', time() - 3600, '/');
header('location:login.php');
