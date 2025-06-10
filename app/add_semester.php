<?php
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $group_ids = $_POST['group_ids'] ?? [];
    $all_class = $_POST['all_class'];
    if (empty($name)) {
        echo json_encode(['status' => 'error', 'message' => 'Tên học kỳ không được để trống.']);
        exit;
    }

    $exists = Capsule::table('semester')->where('name', $name)->exists();

    if ($exists) {
        echo json_encode(['status' => 'error', 'message' => 'Học kỳ đã tồn tại.']);
        exit;
    }

    // Insert học kỳ mới
    $semester_id = Capsule::table('semester')->insertGetId(['name' => $name]);
    if ($all_class == 1) {
        $group_ids = Capsule::table("groupes")->pluck('id')->toArray();
    }
    // Insert vào bảng semester_groups (nếu có group_ids)
    if (!empty($group_ids)) {
        $insertData = [];
        foreach ($group_ids as $group_id) {
            $insertData[] = [
                'semester_id' => $semester_id,
                'group_id' => $group_id,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        Capsule::table('semester_groups')->insert($insertData);
    }

    // Xử lý file Excel
    $data = Capsule::table('form_danh_gia')->get();

    foreach ($data as $row) {
        $studentName = $row->name ?? null;
        if (!$studentName) {
            break;
        }
        $max_score = (float) $row->max_score ?? 0;

        // Insert vào bảng diem_ren_luyen
        Capsule::table('diem_ren_luyen')->insert([
            'name' => $studentName,
            'max_score' => $max_score,
            'semester_id' => $semester_id,
        ]);
    }

    if ($semester_id) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Thêm học kỳ thành công.',
            'id' => $semester_id,
            'name' => $name
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra, vui lòng thử lại.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức không hợp lệ.']);
}
