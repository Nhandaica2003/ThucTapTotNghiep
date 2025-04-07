<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

// Lấy danh sách nhóm học kèm theo tên khóa học
$groups = Capsule::table('groupes')
    ->join('khoa', 'groupes.khoa_id', '=', 'khoa.id')
    ->select('groupes.*', 'khoa.name as course_name')
    ->get();
    $courses = Capsule::table('khoa')->get();
?>
<main class="content">
    <header class="header">
        <div class="container mt-5">
            <h4 class="text-center">Quản Lý Lớp Học</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGroupModal">Thêm Lớp</button>
        </div>
    </header>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Lớp</th>
                    <th>Khóa Học</th>
                    <th>Ngày Tạo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $group): ?>
                    <tr>
                        <td><?= $group->id ?></td>
                        <td>
                            <a href="/app/quan_ly_sinh_vien.php?group_id=<?= $group->id  ?>"><?= $group->group_name ?></a>
                            </td>
                        <td><?= $group->course_name ?></td>
                        <td><?= $group->created_at ?></td>
                        <td>
                            <button class="btn btn-primary editGroupBtn"
                                data-bs-toggle="modal" data-bs-target="#editGroupModal"
                                data-id="<?= $group->id ?>"
                                data-name="<?= $group->group_name ?>"
                                data-khoa="<?= $group->khoa_id ?>">
                                Thay đổi
                            </button>
                            <button class="btn btn-danger deleteGroupBtn" data-id="<?= $group->id ?>">Xóa</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<!-- Modal Add -->
<div class="modal fade" id="addGroupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Lớp Học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label for="newGroupName" class="label-title">Tên Lớp:</label>
                <input type="text" class="form-control" id="newGroupName" placeholder="Nhập tên nhóm">

                <label for="newGroupCourse" class="label-title mt-2">Khóa học:</label>
                <select class="form-select" id="newGroupCourse">
                    <option value="">Chọn Khóa Học</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course->id ?>"><?= $course->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="addGroup">Thêm</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Thay đổi -->
<div class="modal fade" id="editGroupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa Lớp Học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editGroupId">
                <label for="editGroupName" class="label-title">Tên Lớp:</label>
                <input type="text" class="form-control" id="editGroupName" placeholder="Nhập tên nhóm">

                <label for="editGroupCourse" class="label-title mt-2">Khóa học:</label>
                <select class="form-select" id="editGroupCourse">
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course->id ?>"><?= $course->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="saveEditGroup">Lưu</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    // 🟢 Thêm nhóm học
    $("#addGroup").click(function() {
        var groupName = $("#newGroupName").val();
        var khoaId = $("#newGroupCourse").val();

        $.ajax({
            url: "/app/add_group.php",
            type: "POST",
            data: { group_name: groupName, khoa_id: khoaId },
            dataType: "json",
            success: function(response) {
                alert(response.message);
                if (response.status === 'success') {
                    location.reload();
                }
            }
        });
    });

    // 🟡 Mở modal sửa
    $(".editGroupBtn").click(function() {
        var id = $(this).data("id");
        var name = $(this).data("name");
        var khoa = $(this).data("khoa");

        $("#editGroupId").val(id);
        $("#editGroupName").val(name);
        $("#editGroupCourse").val(khoa);
    });

    // 🟠 Lưu chỉnh sửa nhóm học
    $("#saveEditGroup").click(function() {
        var id = $("#editGroupId").val();
        var name = $("#editGroupName").val();
        var khoaId = $("#editGroupCourse").val();

        $.ajax({
            url: "/app/edit_group.php",
            type: "POST",
            data: { id: id, group_name: name, khoa_id: khoaId },
            dataType: "json",
            success: function(response) {
                alert(response.message);
                if (response.status === 'success') {
                    location.reload();
                }
            }
        });
    });

    // 🔴 Xóa nhóm học
    $(".deleteGroupBtn").click(function() {
        var id = $(this).data("id");

        if (confirm("Bạn có chắc muốn xóa nhóm này?")) {
            $.ajax({
                url: "/app/delete_group.php",
                type: "POST",
                data: { id: id },
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
