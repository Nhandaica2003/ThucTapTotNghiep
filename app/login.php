<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ Quản Lí Điểm Ngoại Khoá</title>
    <link rel="stylesheet" href="../../public/css/TrangChu.css">
    <link rel="stylesheet" href="../../public/fontawesome/all.min.css">
    <link href="../../public/boostrap/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../../public/boostrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="login-container">
        <form action="handleLogin.php" method="POST" class="login-form">
            <img src="../images/logoDUE.png" alt="DUE Logo" class="logo">
            <h4 style="margin-bottom: 10px;">Đăng nhập</h4>
            <input type="text" name="username" placeholder="Tên tài khoản" class="input-field">
            
            <input type="password" name="password" placeholder="Mật khẩu" class="input-field">
            <div class="error-message text-danger mb-2">
                <?php
                session_start();
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
            </div>
            <button class="login-button">Đăng nhập</button>
            <div class="forgot-password">
                <a href="#">Quên mật khẩu?</a>
            </div>
        </form>
</body>
<script>

</script>
</html>