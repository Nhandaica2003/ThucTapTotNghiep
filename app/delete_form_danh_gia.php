<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? 0;
    Capsule::table('form_danh_gia')->where('id', $id)->delete();
    echo json_encode(['status' => 'success']);
}

    