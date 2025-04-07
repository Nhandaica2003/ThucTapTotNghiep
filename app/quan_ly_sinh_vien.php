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
$group_id = $_GET['group_id'] ?? null; // Lấy group_id từ session nếu có
$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$total = Capsule::table('users')->count();
$users = Capsule::table('users')
    ->leftJoin('groupes', 'groupes.id', '=', 'users.group_id') // Sửa lại điều kiện join
    ->select('users.*', 'groupes.group_name as group_name')
    ->offset($offset)
    ->limit($limit);
$users = $users->where("users.group_id", "=", $group_id); // Lọc theo group_id
$users = $users->get();

$total_pages = ceil($total / $limit);

$groupes = Capsule::table('groupes')->get();

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
</style>

<main class="content">
    <header class="header">
        <div class="container mt-5">
            <h4 class="text-center">Quản Lý Sinh Viên</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Thêm Sinh viên</button>
        </div>
    </header>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã sinh viên</th>
                    <th>Họ tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Quyền</th>
                    <th>Lớp</th>
                    <th>Chuyên ngành</th>
                    <th>Ngày sinh</th>
                    <th>Hệ đào tạo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $key => $user): ?>
                    <tr>
                        <td><?= $user->ma_sinh_vien ?></td>
                        <td><?= $user->full_name ?></td>
                        <td><?= $user->username ?></td>
                        <td><?= $user->role_name ?></td>
                        <td><?= $user->group_name ?></td>
                        <td><?= $user->chuyennganh ?></td>
                        <td><?= $user->birthday ?></td>
                        <td><?= $user->he_dao_tao ?></td>
                        <td>
                            <button class="btn btn-primary editStudentBtn"
                                data-bs-toggle="modal" data-bs-target="#editModal"
                                data-id="<?= $user->id ?>"
                                data-name="<?= $user->full_name ?>"
                                data-username="<?= $user->username ?>"
                                data-chuyennganh="<?= $user->chuyennganh ?>"
                                data-birthday="<?= $user->birthday ?>"
                                data-role_name="<?= $user->role_name ?>"
                                data-he-dao-tao="<?= $user->he_dao_tao ?>"
                                data-group_id="<?= $user->group_id ?>">
                                Thay đổi
                            </button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $user->id ?>">Xóa</button>
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
                <h5 class="modal-title">Thêm Sinh Viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label for="newStudentId" class="label-title">Mã sinh viên:</label>
                <input type="text" class="form-control" id="newStudentId" placeholder="Nhập mã sinh viên">

                <label for="newStudentName" class="label-title mt-2">Họ và tên:</label>
                <input type="text" class="form-control" id="newStudentName" placeholder="Nhập họ và tên">

                <label for="newUsername" class="label-title mt-2">Tên đăng nhập:</label>
                <input type="text" class="form-control" id="newUsername" placeholder="Nhập tên đăng nhập">

                <label for="newRole" class="label-title mt-2">Quyền:</label>
                <select class="form-control" id="newRole">
                    <option value="sinh vien">Sinh viên</option>
                    <option value="giang vien">Giảng viên</option>
                    <option value="ban can su">Ban cán sự</option>
                </select>

                <label for="newGroup" class="label-title mt-2">Lớp:</label>
                <select name="" class="form-select" id="newGroup">
                    <option value="">Chọn Lớp</option>
                    <?php foreach ($groupes as $group): ?>
                        <option value="<?= $group->id ?>" <?= $group_id == $group->id ? "selected" : ""  ?>><?= $group->group_name ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="newMajor" class="label-title mt-2">Chuyên ngành:</label>
                <input type="text" class="form-control" id="newMajor" placeholder="Nhập chuyên ngành">

                <label for="newHeDaoTao" class="label-title mt-2">Hệ Đào tạo:</label>
                <input type="text" class="form-control" id="newHeDaoTao" placeholder="Nhập hệ đào tạo">

                <label for="newBirthday" class="label-title mt-2">Ngày sinh:</label>
                <input type="date" class="form-control" id="newBirthday">
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="addStudent">Thêm</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Thay đổi -->
<!-- Modal Thay đổi -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa Sinh Viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editStudentId">

                <label for="editStudentName" class="label-title">Họ và tên:</label>
                <input type="text" class="form-control" id="editStudentName" placeholder="Nhập họ và tên">

                <label for="editUsername" class="label-title mt-2">Tên đăng nhập:</label>
                <input type="text" class="form-control" id="editUsername" placeholder="Nhập tên đăng nhập">

                <label for="editRole" class="label-title mt-2">Quyền:</label>
                <select class="form-control" id="editRole">
                    <option value="sinh vien">Sinh viên</option>
                    <option value="giang vien">Giảng viên</option>
                    <option value="ban can su">Ban cán sự</option>
                </select>

                <label for="editGroup" class="label-title mt-2">Lớp:</label>
                <select name="" class="form-select" id="editGroup">
                    <option value="">Chọn Lớp</option>
                    <?php foreach ($groupes as $group): ?>
                        <option value="<?= $group->id ?>" <?= $group_id == $group->id ? "selected" : "" ><?= $group->group_name ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="editMajor" class="label-title mt-2">Chuyên ngành:</label>
                <input type="text" class="form-control" id="editMajor" placeholder="Nhập chuyên ngành">

                <label for="editHeDaoTao" class="label-title mt-2">Hệ Đào tạo:</label>
                <input type="text" class="form-control" id="editHeDaoTao" placeholder="Nhập hệ đào tạo">

                <label for="editBirthday" class="label-title mt-2">Ngày sinh:</label>
                <input type="date" class="form-control" id="editBirthday">
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
                <h5 class="modal-title">Xóa Sinh Viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Bạn có chắc muốn xóa sinh viên này?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Xóa</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var editModal = document.getElementById("editModal");
        editModal.addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute("data-id");
            var name = button.getAttribute("data-name");
            var username = button.getAttribute("data-username");
            var major = button.getAttribute("data-chuyennganh");
            var birthday = button.getAttribute("data-birthday");
            var roleName = button.getAttribute("data-role_name");
            var groupId = button.getAttribute("data-group_id");
            var editHeDaoTao = button.getAttribute("data-he-dao-tao");

            document.getElementById("editStudentId").value = id;
            document.getElementById("editStudentName").value = name;
            document.getElementById("editUsername").value = username;
            document.getElementById("editMajor").value = major;
            document.getElementById("editBirthday").value = birthday;
            document.getElementById("editHeDaoTao").value = editHeDaoTao; // Set hệ đào tạo

            // Set select Role
            var roleSelect = document.getElementById("editRole");
            for (var i = 0; i < roleSelect.options.length; i++) {
                if (roleSelect.options[i].value === roleName) {
                    roleSelect.options[i].selected = true;
                    break;
                }
            }

            // Set select Group (Lớp)
            var groupSelect = document.getElementById("editGroup");
            for (var i = 0; i < groupSelect.options.length; i++) {
                if (groupSelect.options[i].value === groupId) {
                    groupSelect.options[i].selected = true;
                    break;
                }
            }
        });

        var deleteModal = document.getElementById("deleteModal");
        deleteModal.addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute("data-id");
            document.getElementById("confirmDelete").setAttribute("data-id", id);
        });

        $("#addStudent").click(function() {
            var data = {
                ma_sinh_vien: $("#newStudentId").val(),
                full_name: $("#newStudentName").val(),
                username: $("#newUsername").val(),
                role_name: $("#newRole").val(), // Thêm quyền
                group_id: $("#newGroup").val(), // Thêm lớp
                chuyennganh: $("#newMajor").val(),
                birthday: $("#newBirthday").val(),
                he_dao_tao: $("#newHeDaoTao").val() // Thêm hệ đào tạo
            };

            $.ajax({
                url: "/app/add_sinhvien.php",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(response) {
                    alert(response.message);
                    if (response.status === 'success') {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Lỗi:", error);
                    alert("Đã xảy ra lỗi khi thêm sinh viên!");
                }
            });
        });


        $("#saveEdit").click(function() {
            var data = {
                id: $("#editStudentId").val(),
                full_name: $("#editStudentName").val(),
                username: $("#editUsername").val(),
                chuyennganh: $("#editMajor").val(),
                birthday: $("#editBirthday").val(),
                role_name: $("#editRole").val(),
                group_id: $("#editGroup").val(),
                he_dao_tao: $("#editHeDaoTao").val() // Thêm hệ đào tạo
            };

            $.ajax({
                url: "/app/edit_sinhvien.php",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(response) {
                    alert(response.message);
                    if (response.status === 'success') {
                        location.reload();
                    }
                }
            });
        });

        $("#confirmDelete").click(function() {
            var id = $(this).data("id");
            $.ajax({
                url: "/app/delete_sinhvien.php",
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
        });
    });
</script>