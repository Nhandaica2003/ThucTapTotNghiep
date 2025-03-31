<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $deleted = Capsule::table('users')->where('id', $id)->delete();
    echo json_encode(['status' => $deleted ? 'success' : 'error', 'message' => $deleted ? 'Xóa sinh viên thành công.' : 'Có lỗi xảy ra.']);
}