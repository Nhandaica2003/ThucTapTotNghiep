<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

if (empty($_SESSION['user_id'])) {
    header('Location: /app/login.php');
    die();
}

$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$total = Capsule::table('semester')->count();
$semesters = Capsule::table('semester')->offset($offset)->limit($limit)->get();
$total_pages = ceil($total / $limit);
$khoa = Capsule::table('khoa')->get();
foreach ($khoa as $key => $value) {
    $khoa[$key]->groups = Capsule::table('groupes')->where('khoa_id', $value->id)->get();
}
?>

<style>
    .label-title {
        font-weight: bold;
    }

    .clearfix {
        clear: both;
    }

    .pagination {
        margin-top: 20px;
    }

    .select2-container {
        z-index: 99999999999999999;
    }
</style>
<link href="../public/select2/select2.min.css" rel="stylesheet" />
<script src="../public/select2/select2.min.js"></script>
<main class="content">
    <a href="javascript:history.back()" class="btn btn-secondary me-2">← Quay lại</a>

    <header class="header">
        <div class="container mt-5">
            <h4 class="text-center">Quản lý học kỳ</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Thêm Học kỳ</button>
        </div>
    </header>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Học kỳ</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($semesters as $key => $semester): ?>
                    <tr>
                        <td><?= $offset + $key + 1 ?></td>
                        <td><a href="diem_ren_luyen.php?semester_id=<?= $semester->id ?>"><?= $semester->name ?></a></td>
                        <td>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $semester->id ?>" data-name="<?= $semester->name ?>">Thay đổi</button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $semester->id ?>">Xóa</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</main>

<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Học kỳ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="newSemesterName" class="label-title">Tên học kỳ</label>
                    <input type="text" class="form-control" id="newSemesterName" placeholder="Tên học kỳ">
                </div>
                <div class="row mb-3">
                    <label for="khoa" class="label-title">Khoa</label>
                    <select class="form-select select2" id="khoa" name="group_ids[]" multiple required>
                        <?php foreach ($khoa as $key => $value): ?>
                            <optgroup label="<?= $value->name ?>">
                                <?php foreach ($value->groups as $group): ?>
                                    <option value="<?= $group->id ?>"><?= $group->group_name ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                </div>
                  <div class="row mb-3">
                    <label for="newSemesterName" class="label-title">Thêm học kỳ cho tất cả các lớp</label>
                    <input type="checkbox" name="all_class" id="all_class" value="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="addSemester">Thêm</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thay đổi -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa Học kỳ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="editSemesterName" class="label-title">Tên học kỳ</label>
                    <input type="text" class="form-control" id="editSemesterName" placeholder="Tên học kỳ">
                </div>
                <input type="hidden" id="editSemesterId">
                <div class="row mb-3">
                    <label class="form-label">Lớp chủ nhiệm:</label>
                    <select class="form-select select2" name="group_ids[]" id="edit-groups" multiple>
                        <?php foreach ($khoa as $key => $value): ?>
                            <optgroup label="<?= $value->name ?>">
                                <?php foreach ($value->groups as $group): ?>
                                    <option value="<?= $group->id ?>"><?= $group->group_name ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                        <!-- Option của bạn sẽ đổ ở đây -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="saveEdit">Lưu</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa Học kỳ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Bạn có chắc muốn xóa học kỳ này?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Xóa</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Khởi tạo Select2 cho các select box
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Chọn trái cây yêu thích",
            allowClear: true
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        var editModal = document.getElementById("editModal");
        editModal.addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute("data-id");
            var name = button.getAttribute("data-name");
            document.getElementById("editSemesterId").value = id;
            document.getElementById("editSemesterName").value = name;
        });

        var deleteModal = document.getElementById("deleteModal");
        deleteModal.addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute("data-id");
            document.getElementById("confirmDelete").setAttribute("data-id", id);
        });
    });
    $("#addSemester").click(function() {
        var semesterName = $("#newSemesterName").val();
        if (semesterName === "") {
            alert("Vui lòng nhập tên học kỳ.");
            return;
        }
        let selectedValues = $('#khoa').val();
        all_class = 0;
        if ($('#all_class').is(':checked')) {
            all_class =1;
        } 

        $.ajax({
            url: "/app/add_semester.php",
            type: "POST",
            data: {
                name: semesterName,
                group_ids: selectedValues, // Gửi giá trị đã chọn
                all_class: all_class
            },
            dataType: "json", // Thêm dòng này
            success: function(response) {
                console.log("response", typeof response);
                if (response.status === 'success') {
                    console.log("response", response);
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });

    $("#saveEdit").click(function() {
        var semesterId = $("#editSemesterId").val();
        var semesterName = $("#editSemesterName").val();
        var groupIds = $('#edit-groups').val(); // Lấy giá trị đã chọn từ select2
        $.ajax({
            url: "/app/edit_semester.php",
            type: "POST",
            data: {
                id: semesterId,
                name: semesterName,
                group_ids: groupIds // Gửi giá trị đã chọn
            },
            dataType: "json", // Thêm dòng này
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });

    $("#confirmDelete").click(function() {
        var semesterId = $(this).data("id");
        $.ajax({
            url: "/app/delete_semester.php",
            type: "POST",
            data: {
                id: semesterId
            },
            dataType: "json", // Thêm dòng này
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });
</script>