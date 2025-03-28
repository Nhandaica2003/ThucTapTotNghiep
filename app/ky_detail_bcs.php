<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$users = Capsule::table('users')->where('group_id', $user->group_id)->pluck('id');
$semester_name = $_GET['semester_name'] ?? "";

$semesters = Capsule::table('semester')
    ->leftJoin("users", "semester.user_id", "=", "users.id")
    ->whereIn('user_id', $users)
    ->where('name', $semester_name)->get();

$semesterGroups =  Capsule::table('semester')->where('user_id', $user->id)->get();
?>
<main class="content">
    <header class="header">
        <div class="container mt-5">
            <form method="GET" action="">
                <div class="row">
                    <label class="form-label col-md-1" for="">Học kỳ:</label>
                    <div class="col-md-4">
                    <select class="form-select select_semester_name" name="semester_name" id="">
                        <option value="">Chọn học kỳ</option>
                        <?php foreach ($semesterGroups as $semesterGroup): ?>
                            <option value="<?= $semesterGroup->name ?>" <?= $semester_name == $semesterGroup->name ? "selected" : "" ?>><?= $semesterGroup->name ?></option>
                        <?php endforeach; ?>
                    </select>   
                    </div>
                    
                </div>
            </form>
            <h4 class="">Danh sách điểm rèn luyện</h4>
        </div>
    </header>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã sinh viên</th>
                    <th>Họ và tên</th>
                    <th>Điểm SV Tự đánh giá</th>
                    <th>Điểm Lớp đánh giá</th>
                    <th>Điểm GV đánh giá</th>
                    <th>Nhận xét của GV</th>
                    <th>Nhận xét của BCS</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($semesters as $key => $semester): ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $semester->ma_sinh_vien ?></td>
                        <td><?= $semester->full_name ?></td>
                        <td><?= $semester->point ?></td>
                        <td><?= $semester->point_class ?></td>
                        <td><?= $semester->point_teacher ?></td>
                        <td><button value="<?= $semester->comment_teacher ?>" type="button" class="btn btn-primary btn-modal-comment" data-bs-toggle="modal" data-bs-target="#exampleModal">View</button></td>
                        <td><button value="<?= $semester->comment_bcs ?>" type="button" class="btn btn-primary btn-modal-comment" data-bs-toggle="modal" data-bs-target="#exampleModal">View</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".btn-modal-comment").on('click', function() {
            console.log("211");
            var comment = $(this).prop("value");
            $(".modal-body").html(comment);
        });
        $(".select_semester_name").on('change', function() {
            $("form").submit();
        });

    });
</script>
</body>

</html>