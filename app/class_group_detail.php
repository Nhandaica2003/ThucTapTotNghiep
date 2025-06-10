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
$semesters = Capsule::table('semester')->select('semester.*')->join('semester_groups',
    function ($join) use ($group_id) {
        $join->on('semester_groups.semester_id', '=', 'semester.id')
            ->where('semester_groups.group_id', '=', $group_id);
    })->get();
$semesterFirst = $semesters[0];
if(!$semester_id){
    $semester_id = $semesterFirst->id;
}
$users = Capsule::table('users')->select("users.*")->where('group_id', $group_id);
if ($semester_id) {
    $users = $users->leftJoin('duyets', function ($join) use ($semester_id) {
        $join->on('users.id', '=', 'duyets.user_id')
            ->where('duyets.semester_id', '=', $semester_id);
    })->addSelect('duyets.diem_gv_cham', 'duyets.xep_loai', 'duyets.nhan_xet', 'duyets.duyet');
}
$users = $users->get();
$group = Capsule::table('groupes')->where('id', $group_id)->first();
if (!$group) {
    header("Location: /app/class_group.php");
    exit;
}

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
        <a href="javascript:history.back()" class="btn btn-secondary me-2">← Quay lại</a>

    <div class="container mt-5">
        <h4 class="text-center">Lớp <?= $group->group_name  ?></h4>
    </div>
    
    <header class="header">

        <!-- Dropdown và nút -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <label for="semester" class="form-label me-2">Học kỳ:</label>
                <select class="form-select d-inline-block" id="semester">
                    <?php foreach ($semesters as $sem):  ?>
                        <option value='<?= $sem->id ?>' <?= !empty($semester_id) && $semester_id == $sem->id ? "selected" : "" ?>><?= $sem->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <a href="/app/dashboard_lop.php?group_id=<?= $group_id ?>&semester_id=<?= $semester_id ?>" class="btn btn-primary me-2 ms-4">Dashboard</a>
                <a class="btn btn-success me-2 ms-2"
                    href="/app/export_class_group_detail.php?group_id=<?= $group_id ?>&semester_id=<?= $semester_id ?>">
                    Export
                </a>
                <button class="btn btn-info text-white ms-2" id="duyet-submit-id">Duyệt</button>
                 <button class="btn btn-primary text-white ms-2" id="duyet-all">Duyệt Tất cả</button>
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
                        <td><a href="/app/diem_ren_luyen_gvcn.php?user_id=<?= $user->id ?>&semester_id=<?= $semester_id ?>"><?= $user->full_name ?></a> </td>
                        <td><?= $user->birthday ? date('d/m/Y', strtotime($user->birthday)) : "" ?></td>
                        <td><?= $user->diem_gv_cham ?? "" ?></td>
                        <td><?= $user->xep_loai ?? "" ?></td>
                        <td><?= $user->nhan_xet ?? "" ?></td>
                        <td><input class="form-check-input checkbox-duyet"
                                type="checkbox"
                                data-user-id="<?= $user->id ?>"
                                <?= !empty($user->duyet) ? "checked" : "" ?>> </td>
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
            window.location.href = `/app/class_group_detail.php?group_id=<?= $group_id ?>&semester_id=${semesterId}`;
        } else {
            window.location.href = `/app/class_group_detail.php?group_id=<?= $group_id ?>`;
        }
    });
</script>
<script>
    document.getElementById('duyet-submit-id').addEventListener('click', function() {
        const checked = document.querySelectorAll('.checkbox-duyet:checked');
        const semester_id = "<?= $semester_id ?>";
        const userIds = [];

        checked.forEach(cb => {
            userIds.push(cb.dataset.userId);
        });

        // Gửi Ajax
        fetch('/app/duyet_submit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    user_ids: userIds,
                    semester_id: semester_id
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Đã duyệt thành công!');
                } else {
                    message = data.message ?  data.message : 'Có lỗi xảy ra!'; 
                    alert(message);
                }
            })
            .catch(() => alert('Lỗi kết nối!'));
    });
    document.getElementById("duyet-all").addEventListener('click', function() {
        const checked = document.querySelectorAll('.checkbox-duyet');
        const semester_id = "<?= $semester_id ?>";
        const userIds = [];

        checked.forEach(cb => {
            userIds.push(cb.dataset.userId);
        });

                // Gửi Ajax
        fetch('/app/duyet_submit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    user_ids: userIds,
                    semester_id: semester_id
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Đã duyệt thành công!');
                } else {
                    message = data.message ?  data.message : 'Có lỗi xảy ra!'; 
                    alert(message);
                }
            })
            .catch(() => alert('Lỗi kết nối!'));
    })
</script>
</body>

</html>