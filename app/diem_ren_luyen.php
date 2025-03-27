<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// get dữ liệu
if (empty($_SESSION['user_id'])) {
    header('Location: /app/login.php');
    die();
}
$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$semester_id = $_GET['semester_id'] ?? 0;
$semester = Capsule::table('semester')->where('id', $semester_id)->first();

$diem_ren_luyens = Capsule::table('diem_ren_luyen')->where('user_id', $user_id)->where('semester_id', $semester_id)->get();


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
            <h4 class="">Sinh viên đánh giá điểm rèn luyện theo lớp- <?= $semester->name ?></h4>
            <button class="btn btn-primary ms-2 text-end" id="btn-add">Thêm</button>
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
                    <th>Minh chứng</th>
                    <th>Điểm lớp đánh giá (0)</th>
                    <th>Hành động</th>
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
                        <td><button class="btn btn-danger btn-sm btn-delete">Xóa</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const tableBody = document.getElementById("table-body");

    // Thêm hàng mới
    document.getElementById("btn-add").addEventListener("click", function() {
        const newRow = `
            <tr>
                <td><input type="text" class="form-control" name="name"></td>
                <td><input type="number" class="form-control" name="max_score"></td>
                <td><input type="number" class="form-control" name="student_self_assessment_score"></td>
                <td>
                    <input type="file" class="form-control evidence-upload" name="evidence">
                    <input type="hidden" class="form-control evidence-link" name="evidence_link">
                </td>
                <td><input type="number" class="form-control" name="class_assessment_score"></td>
                <td><button class="btn btn-danger btn-sm btn-delete">Xóa</button></td>
            </tr>`;
        tableBody.insertAdjacentHTML("beforeend", newRow);
    });

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
                <td><input type="number" class="form-control" name="max_score" value="${row.children[1].innerText}"></td>
                <td><input type="number" class="form-control" name="student_self_assessment_score" value="${row.children[2].innerText}"></td>
                <td>
                    <input type="file" class="form-control evidence-upload" name="evidence">
                    <input type="hidden" class="form-control evidence-link" value="${imagesrc}" name="evidence_link">
                </td>
                <td><input type="number" class="form-control" name="class_assessment_score" value="${row.children[4].innerText}"></td>
                <td><button class="btn btn-danger btn-sm btn-delete">Xóa</button></td>
            `;
        });
    });

    // Xóa hàng
    tableBody.addEventListener("click", function(event) {
        if (event.target.classList.contains("btn-delete")) {
            event.target.closest("tr").remove();
        }
    });

    // Lưu dữ liệu
    document.getElementById("btn-save").addEventListener("click", async function() {
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
            let item = {
                name: row.querySelector('input[name="name"]').value,
                max_score: row.querySelector('input[name="max_score"]').value,
                student_self_assessment_score: row.querySelector('input[name="student_self_assessment_score"]').value,
                evidence: row.querySelector('input[name="evidence_link"]').value,
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