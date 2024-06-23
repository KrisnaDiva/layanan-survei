<?php
$title = "Dashboard";
ob_start();
session_start();
require_once __DIR__ . '/../../koneksi.php';

$koneksi = getKoneksi();

$sql = "SELECT p.pilihan, COUNT(*) as jumlah
        FROM jawaban j
        JOIN pilihan p ON j.pilihan_id = p.id
        GROUP BY p.pilihan";

$stmt = $koneksi->prepare($sql);
$stmt->execute();

$dataPoints = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dataPoints[] = array("y" => $row['jumlah'], "label" => $row['pilihan']);
}

$sql = "SELECT count(*) as jumlah FROM users WHERE role = 'user'";
$stmt = $koneksi->prepare($sql);
$stmt->execute();
$jumlah_mahasiswa = $stmt->fetchColumn();
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
                                <h4 class="card-title">1</h4>
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
                                <p class="card-category">Cetak</p>
                                <h4 class="card-title">1</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Grafik Survei Layanan"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## response",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
    <div id="chartContainer"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<?php
$content = ob_get_clean();
include("template.php");
?>