<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// get dữ liệu
if (empty($_SESSION['user_id'])) {
    header('Location: /app/login.php');
    die();
}
$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();

$semesters = Capsule::table('semester')->leftJoin('semester_scores', 'semester_scores.semester_id', '=', 'semester.id')
    ->select(
        'semester.*',
        'semester_scores.excellent_count',
        'semester_scores.good_count',
        'semester_scores.fairly_good_count',
        'semester_scores.average_count',
        'semester_scores.weak_count',
        'semester_scores.poor_count'
    )
    ->where('semester.group_id', $user->group_id)->get();


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
        <div class="container mt-5 d-flex">
            <h4 class="">BCS đánh giá điểm</h4>
        </div>
    </header>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Học kỳ</th>
                    <th>Số lượng đạt xuất sắc</th>
                    <th>Số lượng đạt giỏi</th>
                    <th>Số lượng đạt khá</th>
                    <th>Số lượng đạt TB</th>
                    <th>Số lượng đạt Kém</th>
                    <th>Số lượng đạt Yếu</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($semesters as $key => $semester): ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><a href="ky_detail_bcs.php?semester_id=<?= $semester->id ?>"><?= $semester->name ?></a> </td>
                        <td><?= $semester->excellent_count ?: 0 ?></td>
                        <td><?= $semester->good_count ?: 0 ?></td>
                        <td><?= $semester->fairly_good_count ?: 0 ?></td>
                        <td><?= $semester->average_count ?: 0 ?></td>
                        <td><?= $semester->weak_count ?: 0 ?></td>
                        <td><?= $semester->poor_count ?: 0 ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</div>

</body>

</html>