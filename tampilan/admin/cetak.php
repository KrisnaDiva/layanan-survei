<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../koneksi.php';

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
$html = "
<style>
   table {
        width: 100%;
        border-collapse: collapse;
    }
    td, th {
        font-size: 18px;
        text-align: center;
        padding: 8px;
    }

    .right {
        position: absolute;
        top: 60px;
        right: 60px;
    }

</style>
<div class='right'><p>Tanggal Cetak: " . date("d-m-Y") . "</p></div>
";

$html .= "<h1>Cetak Survei</h1>";

$html .= "<p>Prodi: {$prodi}</p>
";

$html .= "<table border='1'>
    <thead>
        <tr>
            <th>Indikator</th>
            {$thElements}
        </tr>
    </thead>
    <tbody>";

$total = array_fill(1, count($pilihan), 0);

foreach ($data as $indikator_id => $counts) {
    $sql = "SELECT indikator FROM indikator WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([$indikator_id]);
    $indikator = $stmt->fetchColumn();
    $html .= "<tr>
        <td>{$indikator}</td>";
    for ($i = 1; $i <= count($pilihan); $i++) {
        $count = isset($counts[$i]) ? $counts[$i] : 0;
        $html .= "<td>" . $count . "</td>";
        $total[$i] += $count;
    }
    $html .= "</tr>";
}

$html .= "<tr>
    <td><b>Total</b></td>";
for ($i = 1; $i <= count($pilihan); $i++) {
    $html .= "<td><b>" . $total[$i] . "</b></td>";
}
$html .= "</tr>
</tbody></table>";

$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);

$mpdf->WriteHTML($html);

$mpdf->Output('Detail Penggajian.pdf', 'I');
?>