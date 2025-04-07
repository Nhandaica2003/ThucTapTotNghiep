<?php
require_once '../database.php';
use Illuminate\Database\Capsule\Manager as DB;

header('Content-Type: application/json');

// Lấy dữ liệu từ form
$fullName = $_POST['full_name'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$group_id = $_POST['group_id'] ?? 0;

// Kiểm tra dữ liệu
if (empty($fullName) || empty($username) || empty($password) || empty($group_id)) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng nhập đầy đủ thông tin']);
    exit;
}

// Kiểm tra tài khoản đã tồn tại chưa
$existingUser = DB::table('users')->where('username', $username)->first();
if ($existingUser) {
    echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập đã tồn tại']);
    exit;
}

// Thêm người dùng mới
$userId = DB::table('users')->insertGetId([
    'full_name' => $fullName,
    'username' => $username,
    'role_name'=> ROLE_BCS,
    'group_id' => $group_id, // Hoặc gán giá trị mặc định nếu cần
    'password' => md5($password), // hoặc md5($password) nếu cần mã hóa
    'created_at' => date('Y-m-d H:i:s')
]);

// Trả về kết quả
echo json_encode(['status' => 'success']);
