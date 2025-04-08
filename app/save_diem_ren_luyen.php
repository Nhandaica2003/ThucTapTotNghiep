<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);
$user_id = $_GET["user_id"] ?? null;
$point_gvcn = 0;
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
        $diem_ren_luyen_user_id = Capsule::table("diem_ren_luyen_user_id")->where(["diem_ren_luyen_id" => $item["id"]])->first();
        if($diem_ren_luyen_user_id){
            $item["student_self_assessment_score"] = !empty($item["student_self_assessment_score"]) ? $item["student_self_assessment_score"]  : $diem_ren_luyen_user_id->student_self_assessment_score;
            $item["class_assessment_score"] = !empty($item["class_assessment_score"]) ? $item["class_assessment_score"] : $diem_ren_luyen_user_id->class_assessment_score;
            $item["teacher_assessment_score"] = !empty($item["teacher_assessment_score"]) ? $item["teacher_assessment_score"] : $diem_ren_luyen_user_id->teacher_assessment_score;
            $item["evidence"] = !empty($item["evidence"]) ? $item["evidence"] : $diem_ren_luyen_user_id->evidence;
        }else{
            $item["student_self_assessment_score"] = !empty($item["student_self_assessment_score"]) ? $item["student_self_assessment_score"]  : 0;
            $item["class_assessment_score"] = !empty($item["class_assessment_score"]) ? $item["class_assessment_score"] : 0;
            $item["teacher_assessment_score"] = !empty($item["teacher_assessment_score"]) ? $item["teacher_assessment_score"] : 0;
            $item["evidence"] = !empty($item["evidence"]) ? $item["evidence"] : "";
        }
       
        
        Capsule::table("diem_ren_luyen_user_id")->updateOrInsert(
            ["diem_ren_luyen_id" => $item["id"]],
            [
                "student_self_assessment_score" => $item["student_self_assessment_score"],
                "evidence" => $item["evidence"] ?? "",
                "class_assessment_score" => $item["class_assessment_score"],
                "teacher_assessment_score" => $item["teacher_assessment_score"],
                "diem_ren_luyen_id" => $item["id"],
                'semester_id' => $diem_ren_luyen->semester_id,
                "user_id" => $user_id,
            ]
        );
        $point_gvcn += $item["teacher_assessment_score"];
    
    }
    if($point_gvcn > 0){
        $duyet = Capsule::table("duyets")->where("user_id", $user_id)->where('semester_id', $diem_ren_luyen->semester_id)->first();
        $xep_loai = getXepLoai($point_gvcn);
        
        Capsule::table("duyets")->where("user_id", $user_id)->where('semester_id', $diem_ren_luyen->semester_id)->updateOrInsert([
            'user_id' => $user_id,
            'semester_id' => $diem_ren_luyen->semester_id],
            [
                'diem_gv_cham' => $point_gvcn,
                'xep_loai' => $xep_loai,
                'nhan_xet' => $duyet->nhan_xet ?? "",
                'duyet' =>  $duyet->duyet ??0,
            ]
        );
    
    }
       echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
