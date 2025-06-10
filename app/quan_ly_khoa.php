<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$courses = Capsule::table('khoa')->get();
?>
<main class="content">
    <a href="javascript:history.back()" class="btn btn-secondary me-2">← Quay lại</a>

    <header class="header">
        <div class="container mt-5">
            <h4 class="text-center">Quản Lý Khóa Học</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">Thêm Khóa Học</button>
        </div>
    </header>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Khóa</th>
                    <th>Ngày Tạo</th>
                    <th>Chỉnh sửa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?= $course->id ?></td>
                        <td><?= $course->name ?></td>
                        <td><?= $course->created_at ?></td>
                        <td>
                            <button class="btn btn-primary editCourseBtn"
                                data-bs-toggle="modal" data-bs-target="#editCourseModal"
                                data-id="<?= $course->id ?>"
                                data-name="<?= $course->name ?>">
                                Thay đổi
                            </button>
                            <button class="btn btn-danger deleteCourseBtn" data-id="<?= $course->id ?>">Xóa</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<!-- Modal Add -->
<div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Khóa Học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label for="newCourseName" class="label-title">Tên khóa học:</label>
                <input type="text" class="form-control" id="newCourseName" placeholder="Nhập tên khóa">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="addCourse">Thêm</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Thay đổi -->
<div class="modal fade" id="editCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa Khóa Học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editCourseId">
                <label for="editCourseName" class="label-title">Tên khóa học:</label>
                <input type="text" class="form-control" id="editCourseName" placeholder="Nhập tên khóa">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="saveEditCourse">Lưu</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // 🟢 Thêm khóa học
        $("#addCourse").click(function() {
            var courseName = $("#newCourseName").val();

            $.ajax({
                url: "/app/add_course.php",
                type: "POST",
                data: {
                    name: courseName
                },
                dataType: "json",
                success: function(response) {
                    alert(response.message);
                    if (response.status === 'success') {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    alert("Lỗi thêm khóa học!");
                }
            });
        });

        // 🟡 Mở modal sửa
        $(".editCourseBtn").click(function() {
            var id = $(this).data("id");
            var name = $(this).data("name");

            $("#editCourseId").val(id);
            $("#editCourseName").val(name);
        });

        // 🟠 Lưu chỉnh sửa khóa học
        $("#saveEditCourse").click(function() {
            var id = $("#editCourseId").val();
            var name = $("#editCourseName").val();

            $.ajax({
                url: "/app/edit_course.php",
                type: "POST",
                data: {
                    id: id,
                    name: name
                },
                dataType: "json",
                success: function(response) {
                    alert(response.message);
                    if (response.status === 'success') {
                        location.reload();
                    }
                }
            });
        });

        // 🔴 Xóa khóa học
        $(".deleteCourseBtn").click(function() {
            var id = $(this).data("id");

            if (confirm("Bạn có chắc muốn xóa khóa học này?")) {
                $.ajax({
                    url: "/app/delete_course.php",
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        alert(response.message);
                        if (response.status === 'success') {
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>