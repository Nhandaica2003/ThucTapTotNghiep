<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    $insert = Capsule::table('khoa')->insert([
        'name' => $name
    ]);

    echo json_encode([
        'status' => $insert ? 'success' : 'error',
        'message' => $insert ? 'Thêm khóa học thành công!' : 'Thêm thất bại!'
    ]);
}
?>
