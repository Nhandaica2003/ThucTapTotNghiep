<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

// Fetch parent items from the database
$parents = Capsule::table('form_danh_gia')->where('parent_id', 0)->get();

foreach ($parents as $parent) {
    $items = Capsule::table('form_danh_gia')->where('parent_id', $parent->id)->get();
    $parent->items = $items;
}
?>
<style>
    .background-primary {
        background: #007bff;
        color: white;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #f4f4f4;
    }
</style>

<div class="container mt-4">
    <a href="javascript:history.back()" class="btn btn-secondary me-2">← Quay lại</a>
    <h1 class="text-center">PHIẾU ĐÁNH GIÁ ĐIỂM RÈN LUYỆN CỦA SINH VIÊN</h1>
    <button class="btn btn-primary mb-3" id="add-parent">+ Thêm mục</button>
    <button class="btn btn-success" id="save">Lưu</button>

    <?php foreach ($parents as $parent): ?>
        <div class="parent-section">
            <div class="background-primary d-flex justify-content-between">
                <span><?php echo $parent->name; ?></span>
                <button class="btn btn-light btn-sm add-child" data-parent-id="<?php echo $parent->id; ?>">+</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nội dung đánh giá</th>
                        <th>Điểm tối đa</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($parent->items as $item): ?>
                        <tr>
                            <td><?php echo $item->name; ?></td>
                            <td><?php echo $item->max_score; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-item" data-id="<?php echo $item->id; ?>">Sửa</button>
                                <button class="btn btn-danger btn-sm delete-item" data-id="<?php echo $item->id; ?>">Xóa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal Thêm/Sửa -->
<div class="modal fade" id="itemModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="itemForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="item-id">
                <input type="hidden" id="item-parent-id">
                <div class="mb-3">
                    <label class="form-label">Tên mục</label>
                    <input type="text" class="form-control" id="item-name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Điểm tối đa</label>
                    <input type="number" class="form-control" id="item-score">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-submit" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        const modal = new bootstrap.Modal(document.getElementById('itemModal'));

        $('#add-parent').click(function() {
            $('.modal-title').text('Thêm mục cha');
            $('#item-id').val('');
            $('#item-name').val('');
            $('#item-parent-id').val(0);
            $('#item-score').val('').parent().hide();
            modal.show();
        });

        $('.add-child').click(function() {
            $('.modal-title').text('Thêm mục con');
            $('#item-id').val('');
            $('#item-name').val('');
            $('#item-score').val('').parent().show();
            $('#item-parent-id').val($(this).data('parent-id'));
            modal.show();
        });

        $('.edit-item').click(function() {
            const id = $(this).data('id');
            $.get(`/app/get_item.php?id=${id}`, function(data) {
                const item = JSON.parse(data);
                $('.modal-title').text('Sửa mục');
                $('#item-id').val(item.id);
                $('#item-name').val(item.name);
                $('#item-score').val(item.max_score).parent().show();
                $('#item-parent-id').val(item.parent_id);
                modal.show();
            });
        });

        $('#btn-submit').click(function(e) {
            const formData = {
                id: $('#item-id').val(),
                name: $('#item-name').val(),
                max_score: $('#item-score').val(),
                parent_id: $('#item-parent-id').val()
            };
            const url = formData.id ? '/app/edit_form_danh_gia.php' : '/app/add_form_danh_gia.php';
            console.log("url", url);
            $.post(url, formData)
                .done(function(response) {
                    // Nếu response là string JSON, cần parse trước
                    try {
                        const res = (typeof response === 'string') ? JSON.parse(response) : response;

                        console.log("parsed response", res);

                        if (res.status === 'success') {
                            modal.hide();
                            location.reload();
                        } else {
                            alert('Gửi thành công nhưng phản hồi lỗi: ' + (res.message || 'Không rõ lý do'));
                        }
                    } catch (e) {
                        alert('Không thể phân tích phản hồi JSON:\n' + response);
                    }
                })
                .fail(function(xhr, status, error) {
                    alert('Lỗi khi gửi dữ liệu: ' + error);
                });

        });

        $('.delete-item').click(function() {
            if (confirm('Bạn có chắc muốn xóa?')) {
                const id = $(this).data('id');
                $.post('/app/delete_form_danh_gia.php', {
                    id: id
                }, function(response) {
                    res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('Xóa thành công!');
                        location.reload();
                    } else {
                        alert('Xóa không thành công!');

                    }
                }).fail(function(xhr, status, error) {
                    alert('Lỗi khi xóa: ' + error);
                });

            }
        });

        $('#save').click(() => alert('Dữ liệu đã được lưu!'));
        $('#preview').click(() => window.open('preview.php', '_blank'));
    });
</script>
</body>

</html>