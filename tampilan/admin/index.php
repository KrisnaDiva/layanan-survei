<?php
$title = "Dashboard";
ob_start();
session_start();
require_once __DIR__ . '/../../koneksi.php';
$koneksi = getKoneksi();

// Fetch available prodies
$sql = "SELECT DISTINCT prodi FROM users WHERE role = 'user'";
$statement = $koneksi->prepare($sql);
$statement->execute();
$prodies = $statement->fetchAll(PDO::FETCH_COLUMN, 0);

// Default selected prodi
$selectedProdi = isset($_GET['prodi']) ? $_GET['prodi'] : 'Manajemen Informatika';
$_SESSION['selectedProdi'] = $selectedProdi;

$sql = "SELECT COUNT(*) as jumlah FROM jawaban";
$statement = $koneksi->prepare($sql);
$statement->execute();
$jumlah_jawaban = $statement->fetchColumn();

$sql = "SELECT count(*) as jumlah FROM users WHERE role = 'user'";
$stmt = $koneksi->prepare($sql);
$stmt->execute();
$jumlah_mahasiswa = $stmt->fetchColumn();

// Default selected prodi
$selectedProdi = isset($_GET['prodi']) ? $_GET['prodi'] : 'Manajemen Informatika';

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

if ($selectedProdi !== 'Semua Prodi') {
    $sql .= " WHERE u.prodi = :prodi";
}

$sql .= " GROUP BY i.indikator, p.pilihan";
$statement = $koneksi->prepare($sql);

if ($selectedProdi !== 'Semua Prodi') {
    $statement->bindParam(':prodi', $selectedProdi);
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
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
            <div class="overflow-hidden d-slider1 swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
                <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline" id="swiper-wrapper-8b14acc2a73dc2fd"
                    aria-live="polite">
                    <li class="swiper-slide card card-slide aos-init aos-animate swiper-slide-active" data-aos="fade-up"
                        data-aos-delay="700" role="group" aria-label="1 / 3"
                        style="width: 155.5px; margin-right: 32px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="bg-success text-white rounded p-3">
                                    <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20px"
                                         viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="text-end">
                                    Data Mahasiswa
                                    <h2 class="counter" style="visibility: visible;"><?= $jumlah_mahasiswa ?></h2>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="swiper-slide card card-slide aos-init aos-animate swiper-slide-next" data-aos="fade-up"
                        data-aos-delay="800" role="group" aria-label="2 / 3"
                        style="width: 155.5px; margin-right: 32px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="bg-info text-white rounded p-3">
                                    <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20px" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div class="text-end">
                                    Data Survei
                                    <h2 class="counter" style="visibility: visible;"><?= $jumlah_jawaban ?></h2>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="swiper-slide card card-slide aos-init aos-animate" data-aos="fade-up"
                        data-aos-delay="800" role="group" aria-label="3 / 3"
                        style="width: 155.5px; margin-right: 32px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="bg-warning text-white rounded p-3">
                                    <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20px"
                                         viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="text-end">
                                    <select id="prodiSelect" class="form-control">
                                        <?php foreach ($prodies as $prodi): ?>
                                            <option value="<?php echo htmlspecialchars($prodi); ?>" <?php echo $selectedProdi === $prodi ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($prodi); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <a id="cetakLink" class="btn btn-primary mt-2" href="cetak.php?prodi=<?= $selectedProdi ?>">Cetak </a>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
                <div class="swiper-button swiper-button-next" tabindex="0" role="button" aria-label="Next slide"
                     aria-controls="swiper-wrapper-8b14acc2a73dc2fd" aria-disabled="false"></div>
                <div class="swiper-button swiper-button-prev swiper-button-disabled" tabindex="-1" role="button"
                     aria-label="Previous slide" aria-controls="swiper-wrapper-8b14acc2a73dc2fd"
                     aria-disabled="true"></div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
        </div>
    </div>
</div>

<div class="container pt-5">
    <form method="get" class="mb-4">
        <label for="prodi">Pilih Prodi:</label>
        <select id="prodi" name="prodi" onchange="this.form.submit()">
            <?php foreach ($prodies as $prodi): ?>
                <option value="<?php echo htmlspecialchars($prodi); ?>" <?php echo $selectedProdi === $prodi ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($prodi); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
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
    window.onload = function () {
    var selectedProdi = "<?php echo $_SESSION['selectedProdi']; ?>";
    var prodiSelect = document.getElementById('prodiSelect');
    for(var i = 0; i < prodiSelect.options.length; i++) {
        if(prodiSelect.options[i].value === selectedProdi) {
            prodiSelect.selectedIndex = i;
            break;
        }
    }
}
    document.getElementById('prodiSelect').addEventListener('change', function () {
        var selectedProdi = this.value;
        var cetakLink = document.getElementById('cetakLink');
        cetakLink.href = 'cetak.php?prodi=' + encodeURIComponent(selectedProdi);
    });

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

<?php
$content = ob_get_clean();
include("template.php");
?>
