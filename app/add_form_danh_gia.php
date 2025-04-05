<?php
// add.php
include_once "../database.php";
header('Content-Type: application/json');

use Illuminate\Database\Capsule\Manager as Capsule;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = !empty($_POST['name']) ? $_POST['name']  : '';
    $max_score = !empty($_POST['max_score']) ? $_POST['max_score']  : 0;
    $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : 0;
    // Validate input data
    Capsule::table('form_danh_gia')->insert([
        'name' => $name,
        'max_score' => $max_score,
        'parent_id' => $parent_id,
    ]);
    echo json_encode(['status' => 'success']);
}