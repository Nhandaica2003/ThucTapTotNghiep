<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ.']);
        exit;
    }
    
    $exists = Capsule::table('semester')->where('id', $id)->exists();
    if (!$exists) {
        echo json_encode(['status' => 'error', 'message' => 'Học kỳ không tồn tại.']);
        exit;
    }
    
    $deleted = Capsule::table('semester')->where('id', $id)->delete();
    if ($deleted) {
        echo json_encode(['status' => 'success', 'message' => 'Xóa học kỳ thành công.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra, vui lòng thử lại.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức không hợp lệ.']);
}