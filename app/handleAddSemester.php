<?php

include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

$semester_name = $_POST['semester_name'] ?? '';
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date']?? '';
$number_practice = $_POST['number_practice']??0;
if (empty($semester_name) || empty($start_date) || empty($end_date)) {
    echo "Vui lòng nhập đầy đủ thông tin";
    return;
}
$semester = Capsule::table('semester')->insert([
    'name' => $semester_name,
    'start_date' => $start_date,
    'end_date' => $end_date,
    'activity_count' => $number_practice,
]);
header("Location: /app/ManageHocKy.php");