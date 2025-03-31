<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];

    $update = Capsule::table('khoa')->where('id', $id)->update([
        'name' => $name
    ]);

    echo json_encode([
        'status' => $update ? 'success' : 'error',
        'message' => $update ? 'Cập nhật thành công!' : 'Cập nhật thất bại!'
    ]);
}
?>
