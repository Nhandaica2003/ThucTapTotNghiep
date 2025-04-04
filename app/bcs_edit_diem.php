<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

// get dữ liệu
if (empty($_SESSION['user_id'])) {
    header('Location: /app/login.php');
    die();
}
$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$user_id_danh_gia = $_GET['user_id'] ?? null;
if (empty($user_id_danh_gia)) {
    die("Lỗi: user_id không được để trống!");
}
$user_danh_gia = Capsule::table('users')->where('id', $user_id_danh_gia)->first();
$semester_id = isset($_GET['semester_id']) ? $_GET['semester_id'] : null;
$semester = Capsule::table('semester')->where('id', $semester_id)->first();
if (empty($semester_id)) {
    die("Lỗi: semester_id không được để trống!");
}
$diem_ren_luyens = Capsule::table('diem_ren_luyen')
    ->select(
        'diem_ren_luyen.*',
        'diem_ren_luyen_user_id.student_self_assessment_score',
        'diem_ren_luyen_user_id.class_assessment_score',
        'diem_ren_luyen_user_id.evidence'
    )
    ->leftJoin(
        'diem_ren_luyen_user_id',
        function ($join) use ($user_id) {
            $join->on('diem_ren_luyen_user_id.diem_ren_luyen_id', '=', 'diem_ren_luyen.id')
                ->where('diem_ren_luyen_user_id.user_id', '=', $user_id);
        }
    )
    ->where('diem_ren_luyen.semester_id', $semester_id)
    ->get();


?>
<style>
    .label-title {
        font-weight: bold;
    }

    .clearfix {
        clear: both;
    }
</style>
<main class="content">
    <header class="header">
        <div class="container mt-5 d-flex">
            <h4 class=""><?= $user_danh_gia->full_name ?> - <?= $semester->name ?></h4>
            <button class="btn btn-primary ms-2 text-end"  data-bs-toggle="modal" data-bs-target="#btn-comment">Nhận xét</button>
            <button class="btn btn-primary ms-4 text-end" id="btn-edit">Cập nhật</button>
            <button class="btn btn-primary ms-4 text-end" id="btn-save">Xem lại</button>
        </div>
    </header>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nội dung và tiêu chí đánh giá</th>
                    <th>Điểm tối đa</th>
                    <th>Điểm sinh viên đánh giá (0)</th>
                    <th>Minh chứng</th>
                    <th>Điểm lớp đánh giá (0)</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($diem_ren_luyens as $key => $diem_ren_luyen): ?>
                    <tr>
                        <td><?= $diem_ren_luyen->name ?></td>
                        <td><?= $diem_ren_luyen->max_score ?></td>
                        <td><?= $diem_ren_luyen->student_self_assessment_score ?></td>
                        <td>
                            <?php if ($diem_ren_luyen->evidence): ?>
                                <img style="height: 200px;" src="<?= $diem_ren_luyen->evidence ?>" alt="">
                            <?php endif; ?>

                        </td>
                        <td><?= $diem_ren_luyen->class_assessment_score ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</div>
<!-- Modal -->
<div class="modal fade" id="btn-comment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title mx-auto" id="exampleModalLabel">Nhận xét</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <textarea class="form-control" rows="5"  placeholder="Chưa đáp ứng đủ tiêu chí"></textarea>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tableBody = document.getElementById("table-body");

    // Xem lại (chuyển tất cả sang input)
    document.getElementById("btn-edit").addEventListener("click", function() {
        document.querySelectorAll("#table-body tr").forEach(row => {
            let imageElement = row.children[3].querySelector("img");
            imagesrc ="";
            if (imageElement) {
                imagesrc = imageElement.src; // Lấy đường dẫn của ảnh
            } else {
                console.log("Không tìm thấy ảnh!");
            }
            row.innerHTML = `
                <td><input type="text" class="form-control" name="name" value="${row.children[0].innerText}"></td>
                <td><input type="number" class="form-control" readonly name="max_score" value="${row.children[1].innerText}"></td>
                <td><input type="number" class="form-control" readonly name="student_self_assessment_score" value="${row.children[2].innerText}"></td>
                <td></td>
                <td><input type="number" class="form-control" name="class_assessment_score" value="${row.children[4].innerText}"></td>
            `;
        });
    });

    // Lưu dữ liệu
    document.getElementById("btn-save").addEventListener("click", async function() {
        let data = [];
        let fileUploads = document.querySelectorAll('.evidence-upload');

        // Thu thập dữ liệu để gửi lên server
        document.querySelectorAll("#table-body tr").forEach(row => {
            let item = {
                name: row.querySelector('input[name="name"]').value,
                max_score: row.querySelector('input[name="max_score"]').value,
                student_self_assessment_score: row.querySelector('input[name="student_self_assessment_score"]').value,
                class_assessment_score: row.querySelector('input[name="class_assessment_score"]').value
            };
            data.push(item);
        });

        fetch("save_diem_ren_luyen.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ diem_ren_luyen: data, semester_id: <?= $semester_id ?> })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert("Lưu thành công!");
                location.reload();
            } else {
                alert("Có lỗi xảy ra!");
            }
        });
    });

});
</script>
</body>

</html>