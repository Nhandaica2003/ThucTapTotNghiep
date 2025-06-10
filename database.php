<?php
require 'vendor/autoload.php';
session_start();

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'thuctaptotnghiep1',
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
class XepLoaiRange {
    const XS   = [90, 100];
    const TOT = [80, 89];
    const KHA  = [65,79];
    const TB  = [50,64 ];
    const YEU   = [35, 49];
    const KEM  = [0,34];
}
function getXepLoai($point) {
    if ($point >= XepLoaiRange::XS[0] && $point <= XepLoaiRange::XS[1]) return "Xuất Sắc";
    if ($point >= XepLoaiRange::TOT[0] && $point <= XepLoaiRange::TOT[1]) return "Tốt";
    if ($point >= XepLoaiRange::KHA[0] && $point <= XepLoaiRange::KHA[1]) return "Khá";
    if ($point >= XepLoaiRange::TB[0] && $point <= XepLoaiRange::TB[1]) return "Trung Bình ";
    if ($point >= XepLoaiRange::YEU[0] && $point <= XepLoaiRange::YEU[1]) return "Yếu";
    if ($point >= XepLoaiRange::KEM[0] && $point <= XepLoaiRange::KEM[1]) return "Kém";
    return "Kém";
}
