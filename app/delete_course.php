<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $delete = Capsule::table('khoa')->where('id', $id)->delete();

    echo json_encode([
        'status' => $delete ? 'success' : 'error',
        'message' => $delete ? 'Xóa thành công!' : 'Xóa thất bại!'
    ]);
}
?>
