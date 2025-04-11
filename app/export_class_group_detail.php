<?php
include_once "../database.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Database\Capsule\Manager as Capsule;

$group_id = $_GET['group_id'] ?? null;
$semester_id = $_GET['semester_id'] ?? null;

if (!$group_id) {
    die("Thiếu group_id");
}

$users = Capsule::table('users')->where('group_id', $group_id);
$users = $users->select("users.*");
if ($semester_id) {
    $users = $users->leftJoin('duyets', function ($join) use ($semester_id) {
        $join->on('users.id', '=', 'duyets.user_id')
            ->where('duyets.semester_id', '=', $semester_id);
    })->addSelect('duyets.diem_gv_cham', 'duyets.xep_loai', 'duyets.nhan_xet', 'duyets.duyet');
}
$users = $users->get();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Tiêu đề cột
$sheet->fromArray([
    'STT', 'Mã sinh viên', 'Họ tên', 'Ngày sinh', 'Điểm GV chấm', 'Xếp loại', 'Nhận xét', 'Duyệt'
], NULL, 'A1');

// Dữ liệu từng dòng
$row = 2;
foreach ($users as $index => $user) {
    $sheet->fromArray([
        $index + 1,
        $user->ma_sinh_vien,
        $user->full_name,
        $user->birthday ? date('d/m/Y', strtotime($user->birthday)) : "",
        $user->diem_gv_cham ?? "",
        $user->xep_loai ?? "",
        $user->nhan_xet ?? "",
        !empty($user->duyet) ? 'Đã duyệt' : 'Chưa duyệt'
    ], NULL, "A$row");
    $row++;
}

// Xuất file
$filename = 'diem_lop_' . date('Ymd_His') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
