<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_name = $_POST['group_name'];
    $khoa_id = $_POST['khoa_id'];

    if (empty($group_name) || empty($khoa_id)) {
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin"]);
        exit;
    }

    $inserted = Capsule::table('groupes')->insert([
        'group_name' => $group_name,
        'khoa_id' => $khoa_id
    ]);

    if ($inserted) {
        echo json_encode(["status" => "success", "message" => "Thêm nhóm học thành công"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi thêm nhóm học"]);
    }
}
?>
