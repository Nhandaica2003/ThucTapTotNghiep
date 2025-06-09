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

$user_id_danh_gia = $_GET['user_id'];
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
        'diem_ren_luyen_user_id.evidence',
        'diem_ren_luyen_user_id.teacher_assessment_score',
    )
    ->leftJoin(
        'diem_ren_luyen_user_id',
        function ($join) use ($user_id_danh_gia) {
            $join->on('diem_ren_luyen_user_id.diem_ren_luyen_id', '=', 'diem_ren_luyen.id')
                ->where('diem_ren_luyen_user_id.user_id', '=', $user_id_danh_gia);
        }
    )
    ->where('diem_ren_luyen.semester_id', $semester_id)
    ->get();
$duyet = Capsule::table('duyets')->where('user_id', $user_id_danh_gia)->where('semester_id', $semester_id)->first();
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
            <h4 class=""><?= $user_danh_gia->full_name ?>- <?= $semester->name ?></h4>
            <button class="btn btn-primary ms-4 text-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Nhận xét
            </button>
            <button class="btn btn-primary ms-4 text-end" id="btn-edit">Xem lại</button>
            <button class="btn btn-primary ms-4 text-end" id="btn-save">Lưu</button>
        </div>
    </header>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nội dung và tiêu chí đánh giá</th>
                    <th>Điểm tối đa</th>
                    <th>Điểm sinh viên đánh giá (0)</th>
                    <th>Điểm sinh BCS Chấm</th>
                    <th>Điểm GV đánh giá (0)</th>
                    <th>Minh chứng</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($diem_ren_luyens as $key => $diem_ren_luyen): ?>
                    <tr>
                        <td data-id="<?= $diem_ren_luyen->id ?>"><?= $diem_ren_luyen->name ?></td>
                        <td><?= $diem_ren_luyen->max_score ?></td>
                        <td><?= $diem_ren_luyen->student_self_assessment_score ?></td>
                        <td><?= $diem_ren_luyen->class_assessment_score ?></td>
                        <td><?= $diem_ren_luyen->teacher_assessment_score ?></td>
                        <td>
                            <?php if ($diem_ren_luyen->evidence): ?>
                                <img style="height: 200px;" src="<?= $diem_ren_luyen->evidence ?>" alt="">
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</div>
<!-- Modal nhận xét -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="nhan_xet_gvcn.php" id="form-nhan-xet" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nhận xét của GVCN</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nhan_xet" class="form-label">Nội dung nhận xét</label>
            <textarea class="form-control" name="nhan_xet" id="nhan_xet" rows="4" required> <?= $duyet->nhan_xet ?></textarea>
          </div>
          <input type="hidden" name="semester_id" value="20242025_2"> <!-- ví dụ học kỳ -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary">Lưu nhận xét</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Xem lại (chuyển tất cả sang input)
        document.getElementById("btn-edit").addEventListener("click", function() {
            document.querySelectorAll("#table-body tr").forEach(row => {
                let imageElement = row.children[3]?.querySelector("img");
                let imagesrc = imageElement ? imageElement.src : "";

                let id_diem_ren_luyen = row.querySelector('td')?.dataset.id || "";
                console.log("ID điểm rèn luyện:", id_diem_ren_luyen);
                row.innerHTML = `
                <td data-id="${id_diem_ren_luyen}"><input type="text" class="form-control" name="name" value="${row.children[0].innerText}"></td>
                <td><input type="number" class="form-control" name="max_score" value="${row.children[1].innerText}"></td>
                <td><input type="number" class="form-control" name="student_self_assessment_score" value="${row.children[2].innerText}"></td>
                <td><input type="number" class="form-control" name="class_assessment_score" value="${row.children[3].innerText}"></td>
                <td><input type="number" class="form-control" name="teacher_assessment_score" value="${row.children[4].innerText}"></td>
                <td>
                    <input type="file" class="form-control evidence-upload" name="evidence">
                    <input type="hidden" class="form-control evidence-link" value="${imagesrc}" name="evidence_link">
                </td>
                <td><button class="btn btn-danger btn-sm btn-delete">Xóa</button></td>
            `;
            });
        });

        // Lưu dữ liệu
        document.getElementById("btn-save").addEventListener("click", async function() {
            console.log("Lưu dữ liệu");
            // Kiểm tra dữ liệu
            let data = [];
            let fileUploads = document.querySelectorAll('.evidence-upload');

            // Upload file trước
            for (let i = 0; i < fileUploads.length; i++) {
                let fileInput = fileUploads[i];
                if (fileInput.files.length > 0) {
                    let formData = new FormData();
                    formData.append("evidence", fileInput.files[0]);

                    let response = await fetch("upload.php", {
                        method: "POST",
                        body: formData
                    });

                    let result = await response.json();
                    if (result.success) {
                        fileInput.nextElementSibling.value = result.file_url;
                    } else {
                        alert("Upload file thất bại!");
                        return;
                    }
                }
            }

            // Thu thập dữ liệu để gửi lên server
            document.querySelectorAll("#table-body tr").forEach(row => {
                console.log(row.querySelector('td'));
                let item = {
                    id: row.querySelector('td').dataset.id,
                    name: row.querySelector('input[name="name"]').value,
                    max_score: row.querySelector('input[name="max_score"]').value,
                    student_self_assessment_score: row.querySelector('input[name="student_self_assessment_score"]').value,
                    teacher_assessment_score: row.querySelector('input[name="teacher_assessment_score"]').value,
                    evidence: row.querySelector('input[name="evidence_link"]').value,
                };
                console.log(item.id);
                data.push(item);
            });
            fetch("save_diem_ren_luyen.php?user_id=<?= $user_id_danh_gia ?>&semester_id=<?= $semester_id ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        diem_ren_luyen: data,
                        semester_id: <?= $semester_id ?>
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert("Lưu thành công!");
                        location.reload();
                    } else {
                        message = result.message ? result.message : "có lỗi xảy ra";
                        alert(message);
                    }
                });
        });

    });

    $('#form-nhan-xet').on('submit', function (e) {
        e.preventDefault();
        data ={
            nhan_xet: $('#nhan_xet').val(),
            user_id: <?= $user_id_danh_gia ?>,
            semester_id: <?= $semester_id ?>
        }

        $.ajax({
        url: '/app/nhan_xet_gvcn.php',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
            alert(response.message);
            $('#exampleModal').modal('hide');
            location.reload()
            // có thể làm thêm: load lại bảng hoặc cập nhật UI
            } else {
            alert('Lỗi: ' + response.message);
            }
        },
        error: function () {
            alert('Đã có lỗi xảy ra khi gửi nhận xét.');
        }
        });
    });
</script>
</body>

</html>