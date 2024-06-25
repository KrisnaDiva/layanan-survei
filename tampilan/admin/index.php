<?php
$title = "Dashboard";
ob_start();
session_start();
require_once __DIR__ . '/../../koneksi.php';

$koneksi = getKoneksi();

$prodiFilter = $_GET['prodi'] ?? null;

if ($prodiFilter) {
    $sql = "SELECT p.pilihan, COUNT(*) as jumlah
            FROM jawaban j
            JOIN pilihan p ON j.pilihan_id = p.id
            JOIN users u ON j.user_id = u.user_id
            WHERE u.prodi = :prodi
            GROUP BY p.pilihan";

    $stmt = $koneksi->prepare($sql);
    $stmt->execute(['prodi' => $prodiFilter]);
} else {
    $sql = "SELECT p.pilihan, COUNT(*) as jumlah
            FROM jawaban j
            JOIN pilihan p ON j.pilihan_id = p.id
            GROUP BY p.pilihan";

    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
}

$totalJumlah=0;
$dataPoints1 = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dataPoints1[] = array("y" => $row['jumlah'], "label" => $row['pilihan']);
    $totalJumlah += $row['jumlah'];
}

if ($prodiFilter) {
    $sql = "SELECT p.pilihan, COUNT(*) as jumlah
            FROM jawaban j
            JOIN pilihan p ON j.pilihan_id = p.id
            JOIN users u ON j.user_id = u.user_id
            WHERE u.prodi = :prodi
            GROUP BY p.pilihan";

    $stmt = $koneksi->prepare($sql);
    $stmt->execute(['prodi' => $prodiFilter]);
} else {
    $sql = "SELECT p.pilihan, COUNT(*) as jumlah
            FROM jawaban j
            JOIN pilihan p ON j.pilihan_id = p.id
            GROUP BY p.pilihan";

    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
}
$dataPoints2 = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $percentage = ($row['jumlah'] / $totalJumlah) * 100;
    $dataPoints2[] = array("y" => $percentage, "label" => $row['pilihan']);
}

$maxValue = 0;
$maxLabel = '';
foreach ($dataPoints2 as $dataPoint) {
    if ($dataPoint['y'] > $maxValue) {
        $maxValue = $dataPoint['y'];
        $maxLabel = $dataPoint['label'];
    }
}

$sql = "SELECT count(*) as jumlah FROM users WHERE role = 'user'";
$stmt = $koneksi->prepare($sql);
$stmt->execute();
$jumlah_mahasiswa = $stmt->fetchColumn();

$sql = "SELECT DISTINCT prodi FROM users WHERE role = 'user'";
$statement = $koneksi->prepare($sql);
$statement->execute();
$prodi = $statement->fetchAll();

$sql = "SELECT COUNT(*) as jumlah FROM jawaban";
$statement = $koneksi->prepare($sql);
$statement->execute();
$jumlah_jawaban = $statement->fetchColumn();
?>

<div class="row mb-5">
    <div class="col-md-4">
        <div class="card card-stats card-warning">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="la la-users"></i>
                        </div>
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <div class="numbers">
                            <p class="card-category">Data Mahasiswa</p>
                            <h4 class="card-title"><?= $jumlah_mahasiswa ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-stats card-success">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="la la-poll"></i>
                        </div>
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <div class="numbers">
                            <p class="card-category">Data Survei</p>
                            <h4 class="card-title"><?= $jumlah_jawaban ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stats card-danger">
            <div class="card-body ">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="la la-print"></i>
                        </div>
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <div class="numbers">
                            <p class="card-category">Cetak Laporan</p>
                            <div class="dropdown">
                                <button class="badge bg-white dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Cetak
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php foreach ($prodi as $row): ?>
                                        <a class="dropdown-item" href="cetak.php?prodi=<?= $row['prodi'] ?>"
                                           target="_blank">Cetak <?= $row['prodi'] ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<select id="prodiSelect" class="form-control mb-5">
    <option value="">Semua Prodi</option>
    <?php foreach ($prodi as $row): ?>
        <option value="<?= $row['prodi'] ?>" <?= $row['prodi'] == $prodiFilter ? 'selected' : '' ?>><?= $row['prodi'] ?></option>
    <?php endforeach; ?>
</select>
<div id="chartContainer" style="margin-bottom: 500px"></div>
<div id="chart1Container"></div>

<script>
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Grafik Survei Layanan <?= $prodiFilter ?? 'Semua Prodi' ?>"
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.## response",
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        var chart1 = new CanvasJS.Chart("chart1Container", {
            animationEnabled: true,
            title: {
                text: "Persentase Survei Layanan"
            },
            subtitles: [{
                text: " <?= $prodiFilter ?? 'Semua Prodi' ?> <?= $maxLabel ?>"
            }],
            data: [{
                type: "pie",
                yValueFormatString: "#,##0.00\"%\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart1.render();


    }
    document.getElementById('prodiSelect').addEventListener('change', function () {
        var selectedProdi = this.value;
        window.location.href = 'index.php?prodi=' + selectedProdi;
    });
</script>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<?php
$content = ob_get_clean();
include("template.php");
?>
