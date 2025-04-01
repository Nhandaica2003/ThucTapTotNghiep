<?php
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    $semester_id = Capsule::table('semester')->insertGetId(['name' => $name]);

    $filePath = '../database/diem_ren_luyen.xlsx'; // Đường dẫn đến file Excel
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    // Bỏ hàng tiêu đề (nếu có)
    array_shift($data);

    foreach ($data as $row) {
        $name = $row[0];
        if(!$name){
            break;
        }
        $max_score = (float) $row[1];
        $student_self_assessment_score = (float) $row[2];
        $class_assessment_score = (float) $row[3];

        // Lấy ID của học kỳ

        // Insert vào bảng diem_ren_luyen
        Capsule::table('diem_ren_luyen')->insert([
            'name' => $name,
            'max_score' => $max_score,
            'student_self_assessment_score' => $student_self_assessment_score,
            'class_assessment_score' => $class_assessment_score,
            'semester_id' => $semester_id,
        ]);
    }


    if ($semester_id) {
        echo json_encode(['status' => 'success', 'message' => 'Thêm học kỳ thành công.', 'id' => $semester_id, 'name' => $name]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra, vui lòng thử lại.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức không hợp lệ.']);
}
