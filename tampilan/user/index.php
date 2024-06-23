<?php
$title = "Home";
ob_start();
session_start();
require_once __DIR__ . '/../../koneksi.php';

$koneksi = getKoneksi();
$sql = "SELECT prodi FROM users WHERE user_id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$prodi = $stmt->fetchColumn();

$sql = "SELECT p.pilihan, COUNT(*) as jumlah
        FROM jawaban j
        JOIN users u ON j.user_id = u.user_id
        JOIN pilihan p ON j.pilihan_id = p.id
        WHERE u.prodi = ?
        GROUP BY p.pilihan, u.prodi";

$stmt = $koneksi->prepare($sql);
$stmt->execute([$prodi]);

$dataPoints = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dataPoints[] = array("y" => $row['jumlah'], "label" => $row['pilihan']);
}
?>
<div id="home"></div>
<div class="row justify-content-center" style="margin-top: 100px; margin-bottom: 100px">
    <div class="card text-center">
        <div class="card-body">
            <div class="row justify-content-center ">
                <div class="col-6">
                    <h2 class="card-title">BERIKAN TANGGAPAN TERHADAP LAYANAN PADA PRODI D-III MANAJEMEN INFORMATIKA &
                        KOMPUTERISASI AKUTANSI</h2>
                </div>
                <div class="mt-5 col-12 mx-auto">
                    <a class="btn btn-primary" href="layanan.php">Beri Tanggapan</a>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "Grafik survei layanan"
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
<script>
    function handleChartLinkActive() {
        document.getElementById('homeLink').classList.remove('active');

        document.getElementById('chartLink').classList.add('active');
    }

    function handleHomeLinkActive() {
        document.getElementById('chartLink').classList.remove('active');

        document.getElementById('homeLink').classList.add('active');
    }

    window.addEventListener('scroll', function() {
        var scrollPosition = window.scrollY;

        var chartElement = document.getElementById('chartContainer');
        var chartPosition = chartElement.offsetTop;

        var windowHeight = window.innerHeight;

        var offset = windowHeight / 2;

        if (scrollPosition > chartPosition - offset) {
            handleChartLinkActive();
        } else {
            handleHomeLinkActive();
        }
    });

    window.addEventListener('load', function() {
        var scrollPosition = window.scrollY;
        var chartElement = document.getElementById('chartContainer');
        var chartPosition = chartElement.offsetTop;
        var windowHeight = window.innerHeight;
        var offset = windowHeight / 2;

        if (scrollPosition > chartPosition - offset) {
            handleChartLinkActive();
        } else {
            handleHomeLinkActive();
        }
    });

    document.getElementById('homeLink').addEventListener('click', function() {
        document.getElementById('chartLink').classList.remove('active');
        document.getElementById('homeLink').classList.add('active');
    });

    document.getElementById('chartLink').addEventListener('click', function() {
        document.getElementById('homeLink').classList.remove('active');
        document.getElementById('chartLink').classList.add('active');
    });
</script>

<?php
$content = ob_get_clean();
include("template.php");
?>
