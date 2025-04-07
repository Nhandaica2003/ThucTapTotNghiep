<?php
require_once '../database.php';
use Illuminate\Database\Capsule\Manager as DB;

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ']);
    exit;
}

// Xóa giáo viên
DB::table('users')->where('id', $id)->delete();

echo json_encode(['status' => 'success']);