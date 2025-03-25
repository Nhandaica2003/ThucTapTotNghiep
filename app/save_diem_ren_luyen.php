<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["diem_ren_luyen"]) && isset($data["semester_id"])) {
    foreach ($data["diem_ren_luyen"] as $item) {
        Capsule::table("diem_ren_luyen")->updateOrInsert(
            ["name" => $item["name"], "semester_id" => $data["semester_id"]],
            [
                "max_score" => $item["max_score"],
                "student_self_assessment_score" => $item["student_self_assessment_score"],
                "evidence" => $item["evidence"],
                "class_assessment_score" => $item["class_assessment_score"],
                "user_id" => $_SESSION["user_id"]
            ]
        );
    }
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
