<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    
    if ($id <= 0 || empty($name)) {
        echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ.']);
        exit;
    }
    
    $exists = Capsule::table('semester')->where('id', $id)->exists();
    if (!$exists) {
        echo json_encode(['status' => 'error', 'message' => 'Học kỳ không tồn tại.']);
        exit;
    }
    
    $updated = Capsule::table('semester')->where('id', $id)->update(['name' => $name]);
    if ($updated) {
        echo json_encode(['status' => 'success', 'message' => 'Cập nhật học kỳ thành công.', 'id' => $id, 'name' => $name]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không có thay đổi hoặc có lỗi xảy ra.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức không hợp lệ.']);
}