<?php
$id = !empty($_GET['id']) ? $_GET['id']: '';
if (empty($id)) {
    echo "Vui lòng nhập id";
    return;
}
include_once "../database.php";
use Illuminate\Database\Capsule\Manager as Capsule;
$semester = Capsule::table('semester')->where('id', $id)->delete();
header("Location: /app/ManageHocKy.php");