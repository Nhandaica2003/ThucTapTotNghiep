<?php
header("Content-Type: application/json");

if (!isset($_FILES["evidence"])) {
    echo json_encode(["success" => false, "message" => "No file uploaded."]);
    exit;
}

$file = $_FILES["evidence"];
$uploadDir = "uploads/";
$allowedExtensions = ["jpg", "jpeg", "png", "pdf", "docx"];
$extension = pathinfo($file["name"], PATHINFO_EXTENSION);

// Kiểm tra định dạng file hợp lệ
if (!in_array(strtolower($extension), $allowedExtensions)) {
    echo json_encode(["success" => false, "message" => "Invalid file type."]);
    exit;
}
// Lấy tên file gốc (không chứa phần mở rộng)
$originalFileName = pathinfo($file["name"], PATHINFO_FILENAME);

// Loại bỏ các ký tự đặc biệt để tránh lỗi
$originalFileName = preg_replace("/[^a-zA-Z0-9_-]/", "", $originalFileName);

// Tạo tên file mới bằng cách nối tên gốc + timestamp + extension
$newFileName = $originalFileName . "_" . time() . "." . $extension;
$targetPath = $uploadDir . $newFileName;

// Di chuyển file vào thư mục uploads
if (move_uploaded_file($file["tmp_name"], $targetPath)) {
    echo json_encode(["success" => true, "file_url" => $targetPath]);
} else {
    echo json_encode(["success" => false, "message" => "File upload failed."]);
}
