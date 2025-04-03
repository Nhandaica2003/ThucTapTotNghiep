<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["diem_ren_luyen"]) && isset($data["semester_id"])) {
    foreach ($data["diem_ren_luyen"] as $item) {
        $diem_ren_luyen = Capsule::table("diem_ren_luyen")
        ->where("id", $item["id"])
        ->first();

        if (empty($diem_ren_luyen)) {
            echo json_encode(["success" => false, "message" => "Lỗi: Không tìm thấy điểm rèn luyện"]);
            die();
        }
        if (empty($diem_ren_luyen)) {
            echo json_encode(["success" => false, "message" => "Lỗi: Không tìm thấy điểm rèn luyện"]);
            die();
        }
        $item["student_self_assessment_score"] = !empty($item["student_self_assessment_score"]) ?$item["student_self_assessment_score"]  : 0;
        $item["class_assessment_score"] = !empty($item["class_assessment_score"]) ? $item["class_assessment_score"] : 0;
        $item["teacher_assessment_score"] = !empty($item["teacher_assessment_score"]) ? $item["teacher_assessment_score"] : 0;
        $item["evidence"] = !empty($item["evidence"]) ? $item["evidence"] : "";
        
        Capsule::table("diem_ren_luyen_user_id")->updateOrInsert(
            ["diem_ren_luyen_id" => $item["id"]],
            [
                "student_self_assessment_score" => $item["student_self_assessment_score"],
                "evidence" => $item["evidence"] ?? "",
                "class_assessment_score" => $item["class_assessment_score"],
                "teacher_assessment_score" => $item["teacher_assessment_score"],
                "diem_ren_luyen_id" => $item["id"],
                'semester_id' => $diem_ren_luyen->semester_id,
                "user_id" => $_SESSION["user_id"]
            ]
        );
    }
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
