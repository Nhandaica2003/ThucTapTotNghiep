<?php
include_once "../database.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Database\Capsule\Manager as Capsule;

$semester_id = $_GET['semester_id'] ?? "";
$semester = Capsule::table('semester')->where('id', $semester_id)->first();
if (!$semester) {
    die("Invalid semester");
}

$users = Capsule::table('users')
    ->select(
        'users.ma_sinh_vien',
        'users.full_name',
        Capsule::raw('SUM(diem_ren_luyen_user_id.student_self_assessment_score) as total_student_self_score'),
        Capsule::raw('SUM(diem_ren_luyen_user_id.class_assessment_score) as total_class_score'),
        Capsule::raw('SUM(diem_ren_luyen_user_id.teacher_assessment_score) as total_teacher_assessment_score'),
        Capsule::raw('ANY_VALUE(comments.comment_teacher) as comment_teacher'),
        Capsule::raw('ANY_VALUE(comments.comment_bcs) as comment_bcs')
    )
    ->leftJoin('diem_ren_luyen_user_id', function ($join) use ($semester_id) {
        $join->on('diem_ren_luyen_user_id.user_id', '=', 'users.id')
            ->where('diem_ren_luyen_user_id.semester_id', '=', $semester_id);
    })
    ->leftJoin('comments', function ($join) use ($semester_id) {
        $join->on('comments.user_id', '=', 'users.id')
            ->where('comments.semester_id', '=', $semester_id);
    })
    ->where('users.group_id', $_GET['group_id'] ?? 0)
    ->groupBy('users.id')
    ->get();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header
$sheet->fromArray([
    'STT', 'Mã SV', 'Họ và tên', 'Điểm SV tự đánh giá', 'Điểm lớp đánh giá', 'Điểm GV đánh giá', 'Nhận xét GV', 'Nhận xét BCS'
], NULL, 'A1');

// Data
$row = 2;
foreach ($users as $index => $user) {
    $sheet->fromArray([
        $index + 1,
        $user->ma_sinh_vien,
        $user->full_name,
        $user->total_student_self_score ?: 0,
        $user->total_class_score ?: 0,
        $user->total_teacher_assessment_score ?: 0,
        $user->comment_teacher,
        $user->comment_bcs
    ], NULL, "A$row");
    $row++;
}

// Export
$filename = 'diem_ren_luyen_' . date('Ymd_His') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
