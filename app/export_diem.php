<?php
include_once "../database.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Database\Capsule\Manager as Capsule;

// Lấy thông tin học kỳ
$semester_id = $_GET['semester_id'] ?? "";
$semester = Capsule::table('semester')->where('id', $semester_id)->first();
if (!$semester) {
    die("Invalid semester");
}

// Lấy danh sách sinh viên
$users = Capsule::table('users')
    ->select(
        'users.ma_sinh_vien',
        'users.full_name',
        'users.birthday',
        'groupes.group_name as group_name',
        'users.group_id',
        Capsule::raw('SUM(diem_ren_luyen_user_id.student_self_assessment_score) as total_student_self_score'),
        Capsule::raw('SUM(diem_ren_luyen_user_id.class_assessment_score) as total_class_score'),
        Capsule::raw('SUM(diem_ren_luyen_user_id.teacher_assessment_score) as total_teacher_assessment_score'),
        Capsule::raw('ANY_VALUE(comments.comment_teacher) as comment_teacher'),
        Capsule::raw('ANY_VALUE(comments.comment_bcs) as comment_bcs'),
        
    )
    ->leftJoin('groupes', 'groupes.id', '=', 'users.group_id')
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

// Tạo file Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Tiêu đề lớn
$sheet->setCellValue('A1', 'BẢNG ĐIỂM RÈN LUYỆN - ' . $semester->name);
$sheet->mergeCells('A1:G1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Header (Dòng 2)
$sheet->fromArray([
    'STT', 'Mã SV', 'Họ và tên', 'Ngày sinh', 'Lớp', 'Điểm do SV tự chấm', 'Điểm do ban cán sự chấm'
], NULL, 'A2');

// Dữ liệu (bắt đầu từ dòng 3)
$row = 3;
foreach ($users as $index => $user) {
    $sheet->fromArray([
        $index + 1,
        $user->ma_sinh_vien,
        $user->full_name,
        $user->birthday ? date('d/m/Y', strtotime($user->birthday)) : "",
        $user->group_name ?: "",
        $user->total_student_self_score ?: 0,
        $user->total_class_score ?: 0,
    ], NULL, "A$row");
    $row++;
}

// Xuất file
$filename = 'diem_ren_luyen_' . date('Ymd_His') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');
ob_clean(); // ✅ Xóa buffer tránh lỗi Excel bị hỏng
$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
?>
