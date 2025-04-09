<?php
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;
header('Content-Type: application/json');

$user_id = $_POST['user_id'] ?? '';
$nhan_xet_bcs = $_POST['nhan_xet_bcs'] ?? '';
$semester_id = $_POST['semester_id'] ?? '';

if ($user_id && $nhan_xet_bcs && $semester_id) {
    // Kiểm tra xem đã có dòng trong bảng duyets chưa
    $exists = Capsule::table('duyets')
        ->where('user_id', $user_id)
        ->where('semester_id', $semester_id)
        ->first();

    if ($exists) {
        // Nếu đã có → update nhận xét
        Capsule::table('duyets')
            ->where('user_id', $user_id)
            ->where('semester_id', $semester_id)
            ->update(['nhan_xet_bcs' => $nhan_xet_bcs]);
    } else {
        // Nếu chưa có → insert mới
        Capsule::table('duyets')->insert([
            'user_id' => $user_id,
            'semester_id' => $semester_id,
            'nhan_xet_bcs' => $nhan_xet_bcs,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Đã lưu nhận xét thành công!'
    ]);
    
} else {
    // Nếu thiếu dữ liệu → thông báo lỗi
    echo json_encode([
        'status' => 'error',
        'message' => 'Thiếu dữ liệu!'
    ]);
}
?>
