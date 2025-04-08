<?php
include_once "./layout/master.php";
include_once "../database.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$group_id = $_GET['group_id'] ?? null;
if (!$group_id) {
    header("Location: /app/class_group.php");
    exit;
}
$semester_id = $_GET['semester_id'] ?? null;
$users = Capsule::table('users')->where('group_id', $group_id)->pluck('id')->toArray();
$duyets = Capsule::table('duyets')
    ->select(Capsule::raw('count(*) as count'), 'duyets.xep_loai')
    ->groupBy('xep_loai')
    ->whereIn('user_id', $users);
if ($semester_id) {
    $duyets = $duyets->where('semester_id', $semester_id);
}
$duyets = $duyets->get();
?>
<script src="../public/chart/chart.js"></script>
<style>
    canvas {
        max-height: 400px;
    }
</style>
<main class="content">
    <div class="mb-4">
        <a href="#" class="text-decoration-none">&larr; DASHBOARD</a>
    </div>

    <div class="d-flex gap-4 mb-4">
        <label class="form-label">Tiêu chí</label>
        <div class="col-md-4">
            <select id="criteria" class="form-select">
                <option value="xep_loai">Xếp loại</option>
                <?php foreach (ARRAY_XEP_LOAI as $item) { ?>
                    <option value="<?= $item ?>"><?= $item ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div>
        <canvas id="chartCanvas"></canvas>
    </div>
</main>
<script>
    const chartData = <?php echo json_encode($duyets); ?>;
    const ctx = document.getElementById('chartCanvas').getContext('2d');
  // Tạo labels và data từ Laravel
  const labels = chartData.map(item => item.xep_loai);
  const dataPoints = chartData.map(item => item.count);
    const data = {
        labels: labels,
        datasets: [{
            label: 'Số lượng',
            data: dataPoints,
            backgroundColor: ['#007bff', '#007bff', '#007bff']
        }]
    };

    let chart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Số lượng'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Xếp loại'
                    }
                }
            }
        }
    });
</script>

</body>

</html>