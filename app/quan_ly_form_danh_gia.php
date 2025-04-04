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

<div class="container">
    <h1>PHIẾU ĐÁNH GIÁ ĐIỂM RÈN LUYỆN CỦA SINH VIÊN</h1>
    <button onclick="window.location.href='add.php'">Thêm mục</button>
    <button onclick="saveData()">Lưu</button>
    <button onclick="previewData()">Xem trước</button>

    <?php foreach ($parents as $parent): ?>
        <div class="parent-section">
            <h2><?php echo $parent->name; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nội dung đánh giá</th>
                        <th>Điểm tối đa </th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($parent->items)): ?>
                        <?php foreach ($parent->items as $item): ?>
                            <tr>
                                <td><?php echo $item->id; ?></td>
                                <td>&nbsp;&nbsp;&nbsp;<?php echo $item->name; ?></td> <!-- Indentation for child items -->
                                <td><?=  $item->max_score ?></td>
                                <td>
                                    <button onclick="editItem(<?php echo $item->id; ?>)">Sửa</button>
                                    <button onclick="deleteItem(<?php echo $item->id; ?>)">Xóa</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function saveData() {
        // Logic to save data
        alert('Dữ liệu đã được lưu!');
    }

    function previewData() {
        // Logic to preview data
        alert('Xem trước dữ liệu!');
    }

    function editItem(id) {
        // Logic to edit item
        window.location.href = `edit.php?id=${id}`;
    }

    function deleteItem(id) {
        if (confirm('Bạn có chắc chắn muốn xóa mục này không?')) {
            // Logic to delete item
            alert('Đã xóa mục có ID: ' + id);
        }
    }
</script>