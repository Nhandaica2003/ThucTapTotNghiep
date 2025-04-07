<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$group_id = $_GET['group_id'] ?? null;
if (!$group_id) {
    header("Location: /app/class_group.php");
    exit;
}

$users = Capsule::table('users')->where('group_id', $group_id)->get();
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
                    <option selected>Học kỳ II năm 2024-2025</option>
                    <!-- Add more options here -->
                </select>
            </div>
            <div>
                <button class="btn btn-primary me-2 ms-4">Dashboard</button>
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
                    <th>Họ và tên lót</th>
                    <th>Tên</th>
                    <th>Ngày sinh</th>
                    <th>Điểm GV chấm</th>
                    <th>Xếp loại</th>
                    <th>Nhận xét</th>
                    <th>Duyệt</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dòng mẫu -->
                <tr>
                    <td>1</td>
                    <td>211121521138</td>
                    <td>Nguyễn Minh</td>
                    <td>Phượng</td>
                    <td>01/01/2003</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input class="form-check-input" type="checkbox"></td>
                </tr>
                <!-- Lặp dòng dữ liệu -->
                <!-- Bạn có thể dùng vòng lặp backend để render thêm dòng -->
                <tr>
                    <td>1</td>
                    <td>211121521138</td>
                    <td>Nguyễn Minh</td>
                    <td>Phượng</td>
                    <td>01/01/2003</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input class="form-check-input" type="checkbox"></td>
                </tr>
                <!-- ... -->
            </tbody>
        </table>
    </div>
</main>
</body>

</html>