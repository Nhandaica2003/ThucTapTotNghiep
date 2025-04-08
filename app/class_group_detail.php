<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$group_id = $_GET['group_id'] ?? null;
if (!$group_id) {
    header("Location: /app/class_group.php");
    exit;
}
$semester_id = $_GET['semester_id'] ?? null;

$users = Capsule::table('users')->where('group_id', $group_id);
if ($semester_id) {
    $users = $users->leftJoin('duyets', function ($join) use ($semester_id) {
        $join->on('users.id', '=', 'duyets.user_id')
            ->where('duyets.semester_id', '=', $semester_id);
    });
}
$users = $users->get();
$group = Capsule::table('groupes')->where('id', $group_id)->first();
if (!$group) {
    header("Location: /app/class_group.php");
    exit;
}
$semester = Capsule::table('semester')->where('group_id', $group_id)->get();
?>
<style>
    th,
    td {
        vertical-align: middle !important;
        text-align: center;
    }

    select.form-select {
        width: auto;
        display: inline-block;
    }
</style>
<main class="content">
    <div class="container mt-5">
        <h4 class="text-center">Lớp <?= $group->group_name  ?></h4>
    </div>
    <header class="header">

        <!-- Dropdown và nút -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <label for="semester" class="form-label me-2">Học kỳ:</label>
                <select class="form-select d-inline-block" id="semester">
                    <option value="">Làm ơn chọn Học kỳ</option>
                    <?php foreach ($semester as $sem):  ?>
                        <option value='<?= $sem->id ?>' <?= !empty($semester_id) && $semester_id == $sem->id ? "selected" :"" ?>><?= $sem->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <a href="/app/dashboard_lop.php?group_id=<?=$group_id?>&semester_id=<?= $semester_id ?>" class="btn btn-primary me-2 ms-4">Dashboard</a>
                <button class="btn btn-success me-2 ms-2">Export</button>
                <button class="btn btn-info text-white ms-2">Duyệt</button>
            </div>
        </div>
    </header>
    <!-- Bảng dữ liệu -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>STT</th>
                    <th>Mã sinh viên</th>
                    <th>Tên</th>
                    <th>Ngày sinh</th>
                    <th>Điểm GV chấm</th>
                    <th>Xếp loại</th>
                    <th>Nhận xét</th>
                    <th>Duyệt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user) { ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $user->ma_sinh_vien ?></td>
                        <td><?= $user->full_name ?></td>
                        <td><?= date('d/m/Y', strtotime($user->birthday)) ?></td>
                        <td><?= $user->diem_gv_cham ?? "" ?></td>
                        <td><?= $user->xep_loai ?? "" ?></td>
                        <td><?= $user->nhan_xet ?? "" ?></td>
                        <td><input class="form-check-input" type="checkbox" <?= !empty($user->duyet) ? "selected" : "" ?>> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>
<script>
    $('#semester').on('change', function() {
        const semesterId = $(this).val();
        const groupId = $(this).data('group-id');
        if (semesterId) {
            window.location.href = `/app/class_group_detail.php?group_id=<?=$group_id?>&semester_id=${semesterId}`;
        } else {
            window.location.href = `/app/class_group_detail.php?group_id=<?=$group_id?>`;
        }
    });
</script>
</body>

</html>