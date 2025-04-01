<?php

include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
if(!$username || !$password){
    $_SESSION['message'] = 'Vui lòng nhập đầy đủ thông tin';
    header('Location: login.php');
    die();
}

$user = Capsule::table('users')->where('username', $username)->first();
if(!$user){
    $_SESSION['message'] = 'Tài khoản không tồn tại';
    header('Location: login.php');
    die();
}

if($user->password ==  md5($password)){
    $_SESSION['user_id'] = $user->id;
    $_SESSION['username'] = $user->username;
    header('Location: /app/hockyhocsinh.php');
    die();
}else{
    $_SESSION['message'] = 'Mật khẩu không đúng';
    header('Location: login.php');
    die();
}


