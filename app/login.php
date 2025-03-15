<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ Quản Lí Điểm Ngoại Khoá</title>
    <link rel="stylesheet" href="../../public/css/TrangChu.css">
</head>
<body>
    <div class="login-container">
        <form action="handleLogin.php" method="POST" class="login-form">
            <img src="../images/logoDUE.png" alt="DUE Logo" class="logo">
            <h4 style="margin-bottom: 10px;">HỆ THỐNG QUẢN LÍ ĐIỂM NGOẠI KHÓA</h4>
            <input type="text" name="username" placeholder="Tên đăng nhập" class="input-field">
            <input type="password" name="password" placeholder="Mật khẩu" class="input-field">
            <button class="login-button">Đăng nhập</button>
            <div class="forgot-password">
                <a href="#">Quên mật khẩu?</a>
            </div>
            <div class="role-selection">
                <label><input type="radio" name="role" value="admin"> Admin</label>
                <label><input type="radio" name="role" value="manager"> Người quản lý</label>
                <label><input type="radio" name="role" value="student" checked> Sinh viên</label>
            </div>
        </form>
</body>
</html>