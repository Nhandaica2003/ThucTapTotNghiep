<?php
require_once '../database.php';
use Illuminate\Database\Capsule\Manager as DB;

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$fullName = $_POST['full_name'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$group_ids = $_POST['group_ids'] ?? [];

if (!$id || empty($fullName) || empty($username) || empty($group_ids)) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đầy đủ thông tin']);
    exit;
}

// Kiểm tra tài khoản có trùng username người khác không
$check = DB::table('users')
    ->where('username', $username)
    ->where('id', '!=', $id)
    ->first();

if ($check) {
    echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập đã tồn tại']);
    exit;
}

// Cập nhật user
$updateData = [
    'full_name' => $fullName,
    'username' => $username,
];

if (!empty($password)) {
    $updateData['password'] = md5($password); // hoặc dùng password_hash
}

DB::table('users')->where('id', $id)->update($updateData);

// Xóa các lớp chủ nhiệm cũ
DB::table('lop_chu_nhiem')->where('user_id', $id)->delete();

// Gán lại lớp mới
foreach ($group_ids as $group_id) {
    DB::table('lop_chu_nhiem')->insert([
        'user_id' => $id,
        'group_id' => $group_id,
        'created_at' => date('Y-m-d H:i:s')
    ]);
}

echo json_encode(['status' => 'success']);
