<?php
session_start();

// Xoá toàn bộ dữ liệu session
session_unset();
session_destroy();

// Chuyển hướng về trang đăng nhập
header('Location: login.php');
exit;
