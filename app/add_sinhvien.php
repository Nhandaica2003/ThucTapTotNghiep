<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $data['password'] = md5('password');
    $insert = Capsule::table('users')->insert($data);
    echo json_encode(['status' => $insert ? 'success' : 'error', 'message' => $insert ? 'Thêm sinh viên thành công.' : 'Có lỗi xảy ra.']);
}
