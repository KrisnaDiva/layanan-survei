<?php
$title = "Home";
ob_start();
?>
<div class="row justify-content-center mb-3">
    <div class="card text-center">
        <div class="card-body">
            <div class="row justify-content-center ">
                <div class="col-6">
                    <h3 class="card-title">BERIKAN TANGGAPAN TERHADAP LAYANAN PADA PRODI D-III MANAJEMEN INFORMATIKA &
                        KOMPUTERISASI AKUTANSI</h3>
                </div>
                <div class="mt-4 col-12 mx-auto">
                    <button class="btn btn-primary">Beri Tanggapan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("template.php");
?>
