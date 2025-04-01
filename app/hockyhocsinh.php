<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// get dữ liệu
if(empty($_SESSION['user_id'])){
    header('Location: /app/login.php');
    die();
}
$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$group = Capsule::table('groupes')->where('id', $user->group_id)->first();
$semesters = Capsule::table('semester')->where('group_id', $user->group_id)->offset($offset)->limit($limit)->get();


?>
<style>
    .label-title {
        font-weight: bold;
    }

    .clearfix {
        clear: both;
    }
</style>
<main class="content">
    <header class="header">
        <div class="container mt-5">
            <h4 class="text-center">ĐIỂM RÈN LUYỆN</h4>

            <div class="row mb-2">
                <div class="col-6">
                    <span class="label-title">Lớp:</span>
                    <span class="label-value"><?= $group->group_name ?></span>
                </div>
                <div class="col-6">
                    <span class="label-title">Hệ:</span>
                    <span class="label-value"><?= $user->he_dao_tao ?></span>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-6">
                    <span class="label-title">Họ và tên:</span>
                    <span class="label-value"><?= $user->full_name ?></span>
                </div>
                <div class="col-6">
                    <span class="label-title">Chuyên ngành:</span>
                    <span class="label-value"><?= $user->chuyennganh ?></span>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-6">
                    <span class="label-title">Ngày sinh:</span>
                    <span class="label-value"><?= $user->birthday ?></span>
                </div>
            </div>
        </div>
    </header>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Học kỳ</th>
                    <th>Điểm rèn luyện</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($semesters as $key => $semester): ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><a href="diem_ren_luyen.php?semester_id=<?= $semester->id ?>"><?= $semester->name ?></a> </td>
                        <td><?= $semester->point ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</div>

</body>

</html>