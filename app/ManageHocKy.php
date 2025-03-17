<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$semesters = Capsule::table('semester')->offset($offset)->limit($limit)->get();
?>
<main class="content">
    <header class="header">
        <div class="header-left">
            <label for="hoc-ky">Học kỳ:</label>
            <select id="hoc-ky">
                <option value="1">Học kỳ 1</option>
                <option value="2">Học kỳ 2</option>
            </select>
            <label for="nam-hoc">Năm học:</label>
            <input type="date" id="nam-hoc">
        </div>
        <div class="header-right">
            <button class="icon-button"><i class="fas fa-bell"></i></button>
            <button class="icon-button"><i class="fas fa-user-cog"></i></button>
            <button class="user-button">Admin <i class="fas fa-chevron-down"></i></button>
        </div>
    </header>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên học kỳ</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Số hoạt động</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($semesters as $semester): ?>
                    <tr>
                        <td><?= $semester->id ?></td>
                        <td><?= $semester->name ?></td>
                        <td><?= $semester->start_date ?></td>
                        <td><?= $semester->end_date ?></td>
                        <td><?= $semester->activity_count ?></td>
                        <td>
                            <button class="icon-button btn btn-primary"><i class="fas fa-edit"></i></button>
                            <a href="/app/deleteSemester.php?id=<?= $semester->id ?>" class="icon-button btn btn-danger" onclick="return   confirm('bạn có muốn xóa không?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Thêm học kỳ +</button>
</main>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm Học Kỳ Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="handleAddSemester.php" method="POST">
            <div class="modal-body">
                
                    <div class="mb-3">
                        <label for="semester-name" class="form-label">Tên học kỳ</label>
                        <input type="text" class="form-control" id="semester-name" name="semester_name">
                    </div>
                    <div class="mb-3">
                        <label for="start-date" class="form-label">Ngày bắt đầu</label>
                        <input type="date" class="form-control" id="start-date" name="start_date">
                    </div>
                    <div class="mb-3">
                        <label for="end-date" class="form-label">Ngày kết thúc</label>
                        <input type="date" class="form-control" id="end-date" name="end_date">
                    </div>
                    <div>
                        <label for="semester-name" class="form-label">Số Hoạt Động</label>
                        <input type="number" class="form-control" id="semester-name" name="number_practice">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="../../public/fontawesome/all.min.js" crossorigin="anonymous"></script>
</body>

</html>