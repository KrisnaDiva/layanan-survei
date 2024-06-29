<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../koneksi.php';

$koneksi = getKoneksi();

$prodi = isset($_GET['prodi']) ? $_GET['prodi'] : 'Manajemen Informatika';

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


<?php
$sql = "SELECT COUNT(*) as jumlah FROM jawaban";
$statement = $koneksi->prepare($sql);
$statement->execute();
$jumlah_jawaban = $statement->fetchColumn();

$sql = "SELECT count(*) as jumlah FROM users WHERE role = 'user'";
$stmt = $koneksi->prepare($sql);
$stmt->execute();
$jumlah_mahasiswa = $stmt->fetchColumn();

$sql = "SELECT pilihan FROM pilihan";
$statement = $koneksi->prepare($sql);
$statement->execute();
$pilihan = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
$colors = [
    'rgba(255, 99, 71, 1)', // red
    'rgba(9, 31, 242, 0.8)', // blue
    'rgba(240, 255, 45, 0.8)', // yellow
    'rgba(17, 231, 42, 0.8)', // green
    'rgba(255, 0, 255, 0.8)', // purple
];

// Fetch data based on selected prodi
$sql = "SELECT i.indikator, p.pilihan, COUNT(*) as jumlah
        FROM jawaban j
        JOIN pilihan p ON j.pilihan_id = p.id
        JOIN indikator i ON j.indikator_id = i.id
        JOIN users u ON j.user_id = u.user_id";

if ($prodi !== 'Semua Prodi') {
    $sql .= " WHERE u.prodi = :prodi";
}

$sql .= " GROUP BY i.indikator, p.pilihan";
$statement = $koneksi->prepare($sql);

if ($prodi !== 'Semua Prodi') {
    $statement->bindParam(':prodi', $prodi);
}

$statement->execute();

$results = $statement->fetchAll(PDO::FETCH_ASSOC);
$data = [];
foreach ($results as $row) {
    $data[$row['indikator']][$row['pilihan']] = $row['jumlah'];
}
$labels = array_keys($data);
$datasets = [];
foreach ($pilihan as $index => $pil) {
    $datasets[] = [
        'label' => $pil,
        'data' => array_column($data, $pil, 0),
        'backgroundColor' => $colors[$index % count($colors)],
        'borderColor' => $colors[$index % count($colors)],
        'borderWidth' => 1
    ];
}
$indicators = array_keys($data);

// Calculate total counts and percentages
$percentages = [];
foreach ($indicators as $indicator) {
    $total = array_sum($data[$indicator]);
    foreach ($pilihan as $pil) {
        $count = $data[$indicator][$pil] ?? 0;
        $percentages[$indicator][$pil] = $total ? ($count / $total) * 100 : 0;
    }
}

?>

<div style="width: 800px">
    <canvas id="barChart" class="mb-5"></canvas>
    <div class="row">
        <?php foreach ($indicators as $index => $indicator): ?>
            <div class="chart-container col-md-6 col-lg-3">
                <canvas id="chart-<?php echo $index; ?>"></canvas>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function() {
    setTimeout(function() {
        window.print();
    }, 2000); // Delay of 2 seconds
}
    const barCtx = document.getElementById('barChart');
    const pieCtxs = <?php echo json_encode(array_map(function ($index) {
        return 'chart-' . $index;
    }, array_keys($indicators))); ?>;

    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: <?php echo json_encode($datasets); ?>
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const colors = <?php echo json_encode($colors); ?>;
    const pilihan = <?php echo json_encode($pilihan); ?>;
    const data = <?php echo json_encode($data); ?>;
    const percentages = <?php echo json_encode($percentages); ?>;

    pieCtxs.forEach((ctxId, index) => {
        const ctx = document.getElementById(ctxId).getContext('2d');
        const indicator = <?php echo json_encode($indicators); ?>[index];

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: pilihan.map(pil => pil + ' (' + percentages[indicator][pil].toFixed(2) + '%)'),
                datasets: [{
                    data: pilihan.map(pil => data[indicator][pil] || 0),
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: indicator
                    }
                }
            }
        });
    });
</script>

</body>
</html>
