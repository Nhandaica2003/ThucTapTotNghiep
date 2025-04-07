<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$khoa_request = isset($_GET['khoa']) ? $_GET['khoa'] : null;
$lop_request = isset($_GET['lop']) ? $_GET['lop'] : null;

$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$total = Capsule::table('users')->where('role_name', ROLE_BCS)->count();
$bcss = Capsule::table('users as u');
$bcss = $bcss->join('groupes as g', 'u.group_id', '=', 'g.id')
  ->select('u.*', 'g.group_name')
  ->where('u.role_name', ROLE_BCS);
if ($khoa_request) {
  $groups = Capsule::table('groupes')->where('khoa_id', $khoa_request)->pluck('id')->toArray();
  $bcss = $bcss->whereIn('u.group_id', $groups);
}
if ($lop_request) {
  $bcss = $bcss->where('u.group_id', $lop_request);
}
$bcss = $bcss->get();
$total_pages = ceil($total / $limit);
$khoa = Capsule::table('khoa')->get();
$groups = Capsule::table('groupes')->get();

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
      <h4 class="text-center">Danh Sách Ban Cán Sự</h4>
      <form>
        <div class="row">
          <!-- Select Khóa -->
          <div class="col-md-3">
            <label for="khoa" class="form-label">Khóa</label>
            <select class="form-select" id="khoa" name="khoa">
              <option selected disabled>Chọn khóa</option>
              <?php foreach ($khoa as $key => $value): ?>
                <option value="<?= $value->id ?>" <?= $khoa_request == $value->id ? "selected": ""  ?> ><?= $value->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Select Lớp -->
          <div class="col-md-3">
            <label for="lop" class="form-label">Lớp</label>
            <select class="form-select" id="lop" name="lop">
              <option selected disabled>Chọn lớp</option>
              <?php foreach ($groups as $key => $value): ?>
                <option value="<?= $value->id ?>" <?= $lop_request == $value->id ? "selected": ""  ?>><?= $value->group_name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- Search Button -->

        </div>
        <div class="row mt-4">
          <div class="col-md-auto" >
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
          </div>
          <div class="col-md-auto">
            <button id="btnOpenCreate" type="button" class="btn btn-success ">+ Tạo Mới</button>
          </div>
        </div>
      </form>
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
          <th>Lớp</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($bcss as $key => $bcs): ?>
          <tr>
            <td><?= $offset + $key + 1 ?></td>
            <td><?= $bcs->full_name ?></td>
            <td><?= $bcs->username ?></td>
            <td><?= $bcs->password ?></td>
            <td><?= $bcs->group_name ?></td>
            <td>
              <button class="btn btn-primary btn-edit"
                data-bs-toggle="modal"
                data-bs-target="#editModal"
                data-id="<?= $bcs->id ?>"
                data-fullname="<?= $bcs->full_name ?>"
                data-username="<?= $bcs->username ?>"
                data-password="<?= $bcs->password ?>"
                data-group="<?= $bcs->group_id ?>">
                Sửa
              </button>

              <button class="btn btn-danger btn-delete"
                data-bs-toggle="modal"
                data-bs-target="#deleteModal"
                data-id="<?= $bcs->id ?>">
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
          <label class="form-label">Chọn lớp:</label>
          <select class="form-select" name="group_id">
            <?php foreach ($groups as $key => $value): ?>
              <option value="<?= $value->id ?>"><?= $value->group_name ?></option>
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
          <label class="form-label">Chọn lớp:</label>
          <select class="form-select select2" name="group_id" id="edit-groups">
            <?php foreach ($groups as $key => $value): ?>
              <option value="<?= $value->id ?>"><?= $value->group_name ?></option>
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
        <p>Bạn có chắc muốn xóa Ban cán sự này không?</p>
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

    $.post('add_bcs.php', formData)
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
  $(document).ready(function() {
    // Xử lý nút Sửa
    $('.btn-edit').click(function() {
      const btn = $(this);
      $('#edit-id').val(btn.data('id'));
      $('#edit-fullname').val(btn.data('fullname'));
      $('#edit-username').val(btn.data('username'));
      $('#edit-password').val(btn.data('password')); // hoặc để trống nếu không sửa

      // Gán selected cho group_ids nếu bạn có danh sách
      const selectedGroups = (btn.data('groups') + '').split(',');
      $('#edit-groups option').each(function() {
        $(this).prop('selected', selectedGroups.includes($(this).val()));
      });
    });

    // Submit sửa
    $('#editForm').submit(function(e) {
      e.preventDefault();
      $.post('edit_bcs.php', $(this).serialize())
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
    $('.btn-delete').click(function() {
      $('#delete-id').val($(this).data('id'));
    });

    // Submit xóa
    $('#deleteForm').submit(function(e) {
      e.preventDefault();
      $.post('delete_bcs.php', $(this).serialize())
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