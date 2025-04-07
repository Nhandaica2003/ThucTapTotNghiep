<?php
require_once '../database.php';
use Illuminate\Database\Capsule\Manager as DB;

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$fullName = $_POST['full_name'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$group_id = $_POST['group_id'] ?? [];

if (!$id || empty($fullName) || empty($username) || empty($group_id)) {
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
    'group_id' => $group_id,
];

if (!empty($password)) {
    $updateData['password'] = $password; // hoặc dùng password_hash
}

DB::table('users')->where('id', $id)->update($updateData);

echo json_encode(['status' => 'success']);
