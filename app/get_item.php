<?php
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;

$id = $_GET['id'];
$item = Capsule::table('form_danh_gia')->where('id', $id)->first();
echo json_encode($item);
