<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

header('Content-Type: application/json');

// Nhận dữ liệu JSON
$input = json_decode(file_get_contents('php://input'), true);

$user_ids = $input['user_ids'] ?? [];
$semester_id = $input['semester_id'] ?? '';

if (!$semester_id || empty($user_ids)) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu dữ liệu']);
    exit;
}

// Duyệt danh sách user_id
foreach ($user_ids as $user_id) {
    $exists = Capsule::table('duyets')
        ->where('user_id', $user_id)
        ->where('semester_id', $semester_id)
        ->first();

    if ($exists) {
        Capsule::table('duyets')
            ->where('user_id', $user_id)
            ->where('semester_id', $semester_id)
            ->update(['duyet' => 1]);
    } else {
        Capsule::table('duyets')->insert([
            'user_id' => $user_id,
            'semester_id' => $semester_id,
            'duyet' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}

echo json_encode(['status' => 'success']);
