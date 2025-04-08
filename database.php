<?php
require 'vendor/autoload.php';
session_start();

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'nhan',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

function dd(...$data)
{
    echo '<pre>';
    foreach ($data as $item) {
        print_r($item);
    }
    echo '</pre>';
    die(); // Dừng thực thi chương trình
}

const ROLE_BCS = "ban can su";
const ROLE_SV = "sinh vien";
const ROLE_GV = "giang vien";
const ROLE_ADMIN = "admin";
const ARRAY_XEP_LOAI = [
    'xuất sắc',
    'giỏi',
    'khá',
    'trung bình',
    'yếu',
    'kém'
];
const XS = [95, 100];
const GIOI = [81, 94];
const KHA = [71, 80];
const TBK = [60, 70];
const TB = [50, 59];
const YEU = [30, 49];
