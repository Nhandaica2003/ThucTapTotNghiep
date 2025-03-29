<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    
    if (empty($name)) {
        echo json_encode(['status' => 'error', 'message' => 'Tên học kỳ không được để trống.']);
        exit;
    }
    
    $exists = Capsule::table('semester')->where('name', $name)->exists();
    if ($exists) {
        echo json_encode(['status' => 'error', 'message' => 'Học kỳ đã tồn tại.']);
        exit;
    }
    
    $id = Capsule::table('semester')->insertGetId(['name' => $name]);
    if ($id) {
        echo json_encode(['status' => 'success', 'message' => 'Thêm học kỳ thành công.', 'id' => $id, 'name' => $name]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra, vui lòng thử lại.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức không hợp lệ.']);
}
