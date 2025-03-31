<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    if (empty($id)) {
        echo json_encode(["status" => "error", "message" => "ID không hợp lệ"]);
        exit;
    }

    $deleted = Capsule::table('groupes')->where('id', $id)->delete();

    if ($deleted) {
        echo json_encode(["status" => "success", "message" => "Xóa nhóm học thành công"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi xóa nhóm học"]);
    }
}
?>
