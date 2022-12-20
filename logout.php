<?php

/**
 * 退出登录
 */
setcookie('password', '', 0, '/');
header('location:login.php');
