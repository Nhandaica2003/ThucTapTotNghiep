<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$khoa_id = $_GET['khoa_id'] ?? null;
$groupes = Capsule::table('groupes')
    ->join('khoa', 'groupes.khoa_id', '=', 'khoa.id')
    ->where('groupes.khoa_id', $khoa_id)
    ->get();
$khoa = Capsule::table('khoa')->where('id', $khoa_id)->first();
if (!$khoa) {
    header("Location: /app/ManageHocKy.php");
    exit;
}
?>
<main class="content">
    <a href="javascript:history.back()" class="btn btn-secondary me-2">← Quay lại</a>
    <header class="header">
        <div class="container mt-5">
            <h4 class="text-center">Khóa <?= $khoa->name  ?></h4>
        </div>
    </header>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên lớp</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groupes as $index => $group) { ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $group->group_name ?></td>
                                <td><a href="/app/class_group_detail.php?group_id=<?= $group->id ?>" class="btn btn-primary">Xem chi tiết</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
</main>
</body>
</html>