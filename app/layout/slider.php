<?php
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$khoas = [];
if ($user->role_name == ROLE_GV) {
    $khoas = Capsule::table('khoa')->get();
}
?>

<body>
    <div class="d-flex h-100 col-12">
        <aside class="sidebar">
            <ul class="menu">
                <div style="display: flex;align-items: center;">
                    <img src="../images/logo.jpg" alt="DUE Logo" class="logo" style="background-image: ;">
                    <span>Quản Lý Điểm Ngoại Khoá</span>
                </div>
                <div class="divider"></div>
                <?php if ($user->role_name == ROLE_GV) { ?>
                    <li>
                        <div class="menu-item has-submenu">
                            <a href="/app/ManageHocKy.php"><i class="fas fa-user"></i> Danh sách Khóa</a>
                            <div class="submenu">
                                <?php foreach ($khoas as $khoa) { ?>
                                    <a href="/app/class_group.php?khoa_id=<?= $khoa->id ?>" class="submenu-item"><?= $khoa->name ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </li>
                <?php } else { ?>
                    <li>
                        <div class="menu-item has-submenu">
                            <a href="/app/ManageHocKy.php"><i class="fas fa-user"></i> Kết quả điểm rèn luyện</a>
                            <div class="submenu">
                                <a href="/app/ManageHocKy.php" class="submenu-item">Điểm rèn luyện của tôi</a>
                                <a href="/app/diem_ren_luyen.php" class="submenu-item">Sinh viên tự đánh giá</a>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="menu-item">
                            <a href="/app/diem_ren_luyen_lop.php"><i class="fas fa-user"></i> Điểm rèn luyện của lớp</a>
                        </div>
                    </li>
                    <?php if ($user->role_name == ROLE_BCS) { ?>
                        <li>
                            <div class="menu-item">
                                <a href="/app/bcs_diem.php"><i class="fas fa-user"></i> BCS đánh giá điểm</a>
                            </div>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </aside>