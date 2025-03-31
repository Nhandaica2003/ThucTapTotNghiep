<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $group_name = $_POST['group_name'];
    $khoa_id = $_POST['khoa_id'];

    if (empty($id) || empty($group_name) || empty($khoa_id)) {
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin"]);
        exit;
    }

    $updated = Capsule::table('groupes')->where('id', $id)->update([
        'group_name' => $group_name,
        'khoa_id' => $khoa_id
    ]);

    if ($updated) {
        echo json_encode(["status" => "success", "message" => "Cập nhật nhóm học thành công"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi cập nhật nhóm học"]);
    }
}
?>
