<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$users = Capsule::table('users')->where('group_id', $user->group_id)->pluck('id');
$semester_id = $_GET['semester_id'] ?? "";
$semester = Capsule::table('semester')->where('id', $semester_id)->first();
if (!$semester) {
    header('Location: /app/bcs_diem.php');
    die();
}

$users = Capsule::table('users')
    ->select(
        'users.*',
        Capsule::raw('SUM(diem_ren_luyen_user_id.student_self_assessment_score) as total_student_self_score'),
        Capsule::raw('SUM(diem_ren_luyen_user_id.class_assessment_score) as total_class_score'),
        Capsule::raw('SUM(diem_ren_luyen_user_id.teacher_assessment_score) as total_teacher_assessment_score'),
        Capsule::raw('ANY_VALUE(comments.comment_teacher) as comment_teacher'),
        Capsule::raw('ANY_VALUE(comments.comment_bcs) as comment_bcs')
    )
    ->leftJoin('diem_ren_luyen_user_id', function ($join) use ($semester_id) {
        $join->on('diem_ren_luyen_user_id.user_id', '=', 'users.id')
            ->where('diem_ren_luyen_user_id.semester_id', '=', $semester_id);
    })
    ->leftJoin('comments', function ($join) use ($semester_id) {
        $join->on('comments.user_id', '=', 'users.id')
            ->where('comments.semester_id', '=', $semester_id);
    })
    ->where('users.group_id', $user->group_id)
    ->groupBy('users.id')
    ->get();


?>
<main class="content">
    <header class="header">
        <div class="container mt-5">

            <h4 class=""><?= $semester->name ?></h4>
            <h4 class="text-center">DANH SÁCH ĐIỂM RÈN LUYỆN</h4>
            <div class="ml-auto d-flex align-items-center">
                <button class="btn btn-primary" onclick="window.location.href='export_diem.php?semester_id=<?= $semester_id ?>&group_id=<?= $user->group_id ?>'">
                    Export
                </button>
                <a href="/app/dashboard_lop.php?group_id=<?=$user->group_id?>&semester_id=<?= $semester_id ?>" class="btn btn-primary ms-4" aria-labelledby="dropdownMenuButton">
                    Dashboard
                </a>
            </div>
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
                <?php foreach ($users as $key => $user): ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td> <?= $user->ma_sinh_vien ?></td>
                        <td><a href="/app/bcs_edit_diem.php?user_id=<?= $user->id ?>&semester_id=<?= $semester->id ?>"><?= $user->full_name ?></a></td>
                        <td><?= $user->total_student_self_score ?: 0 ?></td>
                        <td><?= $user->total_class_score ?: 0 ?></td>
                        <td><?= $user->total_teacher_assessment_score ?: 0 ?></td>
                        <td><button value="<?= $user->comment_teacher ?>" type="button" class="btn btn-primary btn-modal-comment" data-bs-toggle="modal" data-bs-target="#exampleModal">View</button></td>
                        <td><button value="<?= $user->comment_bcs ?>" type="button" class="btn btn-primary btn-modal-comment" data-bs-toggle="modal" data-bs-target="#exampleModal">View</button></td>
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