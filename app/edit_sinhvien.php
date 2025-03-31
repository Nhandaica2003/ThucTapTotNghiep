<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    unset($_POST['id']);

    $updated = Capsule::table('users')->where('id', $id)->update($_POST);
    echo json_encode(['status' => $updated ? 'success' : 'error', 'message' => $updated ? 'Cập nhật sinh viên thành công.' : 'Có lỗi xảy ra.']);
}
