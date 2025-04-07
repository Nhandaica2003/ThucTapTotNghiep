<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;


$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$total = Capsule::table('users')->where('role_name', ROLE_GV)->count();
$teachers =  Capsule::table('users as u')
    ->leftJoin('lop_chu_nhiem as l', 'u.id', '=', 'l.user_id')
    ->leftJoin('groupes as g', 'l.group_id', '=', 'g.id')
    ->select(
        'u.id',
        'u.full_name',
        'u.username',
        'u.password',
        Capsule::raw('GROUP_CONCAT(g.group_name SEPARATOR ", ") as group_names'),
        Capsule::raw('GROUP_CONCAT(g.id SEPARATOR ",") as group_ids',)
    )->where('role_name', ROLE_GV)
    ->groupBy('u.id', 'u.full_name', 'u.username', 'u.password')
    ->get();
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
    .select2-container{
        z-index: 99999999999999999;
    }
</style>
<link href="../public/select2/select2.min.css" rel="stylesheet" />
<script  src="../public/select2/select2.min.js"></script>
<main class="content">
    <header class="header">
        <div class="container mt-5">
            <h4 class="text-center">Danh Sách Giáo Viên Chủ Nhiệm</h4>
            <button id="btnOpenCreate" class="btn btn-success">+ Tạo Mới</button>
        </div>
    </header>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Mật Khẩu</th>
                    <th>Lớp chủ nhiệm</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teachers as $key => $teacher): ?>
                    <tr>
                        <td><?= $offset + $key + 1 ?></td>
                        <td><?= $teacher->full_name ?></td>
                        <td><?= $teacher->username ?></td>
                        <td><?= $teacher->password ?></td>
                        <td><?= $teacher->group_names ?></td>
                        <td>
                            <button class="btn btn-primary btn-edit"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal"
                                data-id="<?= $teacher->id ?>"
                                data-fullname="<?= $teacher->full_name ?>"
                                data-username="<?= $teacher->username ?>"
                                data-password="<?= $teacher->password ?>"
                                data-groups="<?= $teacher->group_ids ?>">
                                Sửa
                            </button>

                            <button class="btn btn-danger btn-delete"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="<?= $teacher->id ?>">
                                Xóa
                            </button>
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
<!-- Modal Tạo Mới -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" id="createForm">
            <div class="modal-header">
                <h5 class="modal-title">TẠO MỚI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Họ và tên:</label>
                    <input type="text" class="form-control" name="full_name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập:</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nhập lại mật khẩu:</label>
                    <input type="password" class="form-control" name="confirm_password" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Chọn lớp chủ nhiệm:</label>
                    <select class="form-select select2" name="group_ids[]" multiple required>
                        <?php foreach ($khoa as $key => $value): ?>
                            <optgroup label="<?= $value->name ?>">
                                <?php foreach ($value->groups as $group): ?>
                                    <option value="<?= $group->id ?>"><?= $group->group_name ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Tạo mới</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal Sửa -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="editForm">
      <div class="modal-header">
        <h5 class="modal-title">Chỉnh sửa thông tin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit-id">
        <div class="mb-3">
          <label class="form-label">Họ và tên:</label>
          <input type="text" class="form-control" name="full_name" id="edit-fullname" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Tên đăng nhập:</label>
          <input type="text" class="form-control" name="username" id="edit-username" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Mật khẩu:</label>
          <input type="password" class="form-control" name="password" id="edit-password">
        </div>
        <div class="mb-3">
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
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </form>
  </div>
</div>
<!-- Modal Xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" id="deleteForm">
      <div class="modal-header">
        <h5 class="modal-title">Xác nhận xóa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Bạn có chắc muốn xóa giáo viên này không?</p>
        <input type="hidden" name="id" id="delete-id">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Xóa</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
      </div>
    </form>
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
    const createModal = new bootstrap.Modal(document.getElementById('createModal'));

    // Ví dụ nút mở modal
    document.getElementById('btnOpenCreate').addEventListener('click', () => {
        document.getElementById('createForm').reset();
        createModal.show();
    });

    // Submit form
    $('#createForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post('add_lop_chu_nhiem.php', formData)
            .done(function(res) {
                const response = typeof res === 'string' ? JSON.parse(res) : res;
                if (response.status === 'success') {
                    createModal.hide();
                    alert('Tạo mới thành công!');
                    location.reload();
                } else {
                    alert('Lỗi: ' + response.message);
                }
            })
            .fail(function(xhr, status, error) {
                alert('Lỗi AJAX: ' + error);
            });
    });
</script>
<script>
  $(document).ready(function () {
    // Xử lý nút Sửa
    $('.btn-edit').click(function () {
      const btn = $(this);
      $('#edit-id').val(btn.data('id'));
      $('#edit-fullname').val(btn.data('fullname'));
      $('#edit-username').val(btn.data('username'));
      $('#edit-password').val(btn.data('password')); // hoặc để trống nếu không sửa

      // Gán selected cho group_ids nếu bạn có danh sách
      const selectedGroups = (btn.data('groups') + '').split(',');
      $('#edit-groups option').each(function () {
        $(this).prop('selected', selectedGroups.includes($(this).val()));
      });
    });

    // Submit sửa
    $('#editForm').submit(function (e) {
      e.preventDefault();
      $.post('edit_lop_chu_nhiem.php', $(this).serialize())
        .done(res => {
          console.log(res);
          if (res.status === 'success') {
            alert('Cập nhật thành công!');
            location.reload();
          } else {
            alert('Lỗi: ' + res.message);
          }
        });
    });

    // Xử lý nút Xóa
    $('.btn-delete').click(function () {
      $('#delete-id').val($(this).data('id'));
    });

    // Submit xóa
    $('#deleteForm').submit(function (e) {
      e.preventDefault();
      $.post('delete_giao_vien.php', $(this).serialize())
        .done(res => {
          if (res.status === 'success') {
            alert('Đã xóa!');
            location.reload();
          } else {
            alert('Lỗi khi xóa: ' + res.message);
          }
        });
    });
  });
</script>
