<?php
$title = "Grafik";
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
<?php
$content = ob_get_clean();
include("template.php");
?>