<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../koneksi.php';

$koneksi = getKoneksi();

$prodi = isset($_GET['prodi']) ? $_GET['prodi'] : null;

if ($prodi) {
    $sql = "SELECT j.indikator_id, j.pilihan_id, COUNT(*) as jumlah
            FROM jawaban j
            WHERE j.user_id IN (SELECT user_id FROM users WHERE prodi = ?)
            GROUP BY j.indikator_id, j.pilihan_id";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([$prodi]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$data = [];
foreach ($result as $row) {
    if (!isset($data[$row['indikator_id']])) {
        $data[$row['indikator_id']] = [];
    }
    $data[$row['indikator_id']][$row['pilihan_id']] = $row['jumlah'];
}

$sqlPilihan = "SELECT pilihan FROM pilihan ORDER BY id";
$stmtPilihan = $koneksi->prepare($sqlPilihan);
$stmtPilihan->execute();
$pilihan = $stmtPilihan->fetchAll(PDO::FETCH_COLUMN);

$thElements = "";
foreach ($pilihan as $pil) {
    $thElements .= "<th>{$pil}</th>";
}
$sql = "SELECT p.pilihan, COUNT(*) as jumlah
            FROM jawaban j
            JOIN users u ON j.user_id = u.user_id
            JOIN pilihan p ON j.pilihan_id = p.id
            WHERE u.prodi = ?
            GROUP BY p.pilihan, u.prodi";
$stmt = $koneksi->prepare($sql);
$stmt->execute([$prodi]);
$dataPoints = array();
$totalJumlah=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dataPoints[] = array("y" => $row['jumlah'], "label" => $row['pilihan']);
    $totalJumlah += $row['jumlah'];
}
$sql = "SELECT p.pilihan, COUNT(*) as jumlah
            FROM jawaban j
            JOIN users u ON j.user_id = u.user_id
            JOIN pilihan p ON j.pilihan_id = p.id
            WHERE u.prodi = ?
            GROUP BY p.pilihan, u.prodi";
$stmt = $koneksi->prepare($sql);
$stmt->execute([$prodi]);
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

?>
<html>
<head>
    <title>Cetak Survei</title>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            body {
                width: 210mm;
                height: 297mm;
                margin: 20mm; /* Set margin as needed */
                padding: 0;
            }
        }

        .right {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td, th {
            font-size: 18px;
            text-align: center;
            padding: 8px;
            border: 1px solid black;
        }

        .right {
            position: absolute;
            top: 60px;
            right: 60px;
        }
    </style>
</head>

<body>
<div class='right'><p>Tanggal Cetak: <?= date("d-m-Y") ?></p></div>
<h1>Cetak Survei</h1>
<p>Prodi: <?= $prodi ?></p>
<table border='1'>
    <thead>
    <tr>
        <th>Indikator</th>
        <?= $thElements ?>
    </tr>
    </thead>
    <tbody>
    <?php
    $total = array_fill(1, count($pilihan), 0);

    foreach ($data as $indikator_id => $counts) {
        $sql = "SELECT indikator FROM indikator WHERE id = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->execute([$indikator_id]);
        $indikator = $stmt->fetchColumn();
        ?>
        <tr>
            <td><?= $indikator ?></td>
            <?php
            for ($i = 1; $i <= count($pilihan); $i++) {
                $count = isset($counts[$i]) ? $counts[$i] : 0;
                ?>
                <td><?= $count ?></td>
                <?php
                $total[$i] += $count;
            }
            ?>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td><b>Total</b></td>
        <?php
        for ($i = 1; $i <= count($pilihan); $i++) {
            ?>
            <td><b><?= $total[$i] ?></b></td>
            <?php
        }
        ?>
    </tr>
    <tr>
        <td><b>Persentase</b></td>
        <?php
        foreach ($total as $count) {
            $percentage = ($count / $totalJumlah) * 100;
            ?>
            <td><b><?= number_format($percentage, 2) ?>%</b></td>
            <?php
        }
        ?>
    </tr>
    </tbody>
</table>
<div id="chartContainer1" style="height: 370px; width: 50%; margin-bottom: 50px"></div>
<div id="chartContainer2" style="height: 370px; width: 50%;"></div>

<script>
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Grafik survei layanan"
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.## response",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

         // Wait for 1 second before triggering print dialog
        var chart1 = new CanvasJS.Chart("chartContainer2", {
            animationEnabled: true,
            title: {
                text: "Persentase Survei Layanan"
            },
            subtitles: [{
                text: " <?= $maxLabel ?>"
            }],
            data: [{
                type: "pie",
                yValueFormatString: "#,##0.00\"%\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }]
        });
          chart1.render();
        setTimeout(function () {
            window.print();
        }, 2000);
    }
</script>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>
