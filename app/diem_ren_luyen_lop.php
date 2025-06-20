<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$user_id = $_SESSION['user_id'];
$user = Capsule::table('users')->where('id', $user_id)->first();
$semester_name = $_GET['semester_name'] ?? "";
if ($semester_name) {
    $semester = Capsule::table('semester')->where('name', $semester_name)->first();
} else {
    $semester = Capsule::table('semester')->leftJoin('semester_groups', 'semester.id', '=', 'semester_groups.semester_id')
        ->where('semester_groups.group_id', $user->group_id)->select('semester.*')
        ->first();
        $semester_name = $semester->name;
}
$users = Capsule::table('users')->where('group_id', $user->group_id)
->leftJoin('duyets', function ($join) use ($semester) {
    $join->on('duyets.user_id', '=', 'users.id')
         ->where('duyets.semester_id', '=', $semester->id);
})
->select('users.*', 'duyets.diem_gv_cham', 'duyets.sv_cham', 'duyets.bcs_cham', 'duyets.nhan_xet', 'duyets.nhan_xet_bcs') // hoặc tùy thuộc field bạn muốn lấy
->get();
$semesterGroups = Capsule::table('semester_groups')
    ->leftJoin('semester', 'semester_groups.semester_id', '=', 'semester.id')
    ->where('semester_groups.group_id', $user->group_id)
    ->select('semester.*')
    ->get();

?>
<main class="content">

    <style>
        a {
            text-decoration: none ;
            color: blue;
        }

       
    </style>


    <a href="javascript:history.back()" class="btn btn-secondary me-2">← Quay lại</a>

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
                <?php foreach ($users as $key => $user): ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td> <?= $user->ma_sinh_vien ?></td>
                        <td><a href="/app/bcs_edit_diem.php?semester_id=<?=$semester->id?>&user_id=<?= $user->id ?>"><?= $user->full_name ?></a></td>
                        <td><?= $user->sv_cham ?></td>
                        <td><?= $user->bcs_cham ?></td>
                        <td><?= $user->diem_gv_cham ?></td>
                        <td><button value="<?= $user->nhan_xet ?>" type="button" class="btn btn-primary btn-modal-comment" data-bs-toggle="modal" data-bs-target="#exampleModal">View</button></td>
                        <td><button value="<?= $user->nhan_xet_bcs ?>" type="button" class="btn btn-primary btn-modal-comment" data-bs-toggle="modal" data-bs-target="#exampleModal">View</button></td>
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
                <h5 class="modal-title" id="exampleModalLabel">Nhận xét</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary">Lưu</button>
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