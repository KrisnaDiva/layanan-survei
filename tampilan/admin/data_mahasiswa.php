<?php
$title = "Data Mahasiswa";
ob_start();

require_once __DIR__ . '/../../koneksi.php';
$koneksi = getKoneksi();

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM users WHERE role = 'user' AND 
        (nama LIKE :search OR npm LIKE :search OR fakultas LIKE :search OR prodi LIKE :search OR email LIKE :search OR username LIKE :search)
        LIMIT :limit OFFSET :offset";
$statement = $koneksi->prepare($sql);
$searchTerm = "%$search%";
$statement->bindParam(':search', $searchTerm, PDO::PARAM_STR);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$users = $statement->fetchAll();

$sql = "SELECT COUNT(*) FROM users WHERE role = 'user' AND 
        (nama LIKE :search OR npm LIKE :search OR fakultas LIKE :search OR prodi LIKE :search OR email LIKE :search OR username LIKE :search)";
$statement = $koneksi->prepare($sql);
$statement->bindParam(':search', $searchTerm, PDO::PARAM_STR);
$statement->execute();
$total_rows = $statement->fetchColumn();
$total_pages = ceil($total_rows / $limit);
?>

<div class="row justify-content-center mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Mahasiswa</div>
                <div class="input-group mt-3 col-4">
                    <input type="text" id="search" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
                </div>
            </div>
            <div class="card-body text-right">
                <table class="table text-center">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NPM</th>
                        <th>Fakultas</th>
                        <th>Prodi</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody id="userTable">
                    <?php foreach ($users as $key => $value): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $value['nama']; ?></td>
                            <td><?= $value['npm']; ?></td>
                            <td><?= $value['fakultas']; ?></td>
                            <td><?= $value['prodi']; ?></td>
                            <td><?= $value['email']; ?></td>
                            <td><?= $value['username']; ?></td>
                            <td style="display: inline-block;">
                                <a href="edit_mahasiswa.php?id=<?= $value['user_id']; ?>" class="btn btn-warning"
                                   style="display: inline-block;"><i class="las la-edit"></i></a>
                                <form method="POST" action="../../proses/hapus_mahasiswa.php"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');"
                                      style="display: inline-block;">
                                    <input type="hidden" name="id" value="<?= $value['user_id']; ?>">
                                    <button type="submit" class="btn btn-danger"><i class="las la-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <?php
                $entries_start = $offset + 1;
                $entries_end = $offset + count($users);
                $total_entries = $total_rows;

                echo "Menampilkan {$entries_start} sampai {$entries_end} dari {$total_entries} data"; ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                       href="?page=1&search=<?= htmlspecialchars($search) ?>">First</a></li>
                        <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                       href="?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($search) ?>"><</a>
                        </li>
                        <?php
                        $num_links_to_display = 2;
                        $start = max(1, $page - $num_links_to_display);
                        $end = min($total_pages, $page + $num_links_to_display);
                        for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>"><a class="page-link"
                                                                                          href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                                  href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($search) ?>">></a>
                        </li>
                        <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>"><a class="page-link"
                                                                                                  href="?page=<?= $total_pages ?>&search=<?= htmlspecialchars($search) ?>">Last</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', function() {
        const search = this.value;
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '?page=1&search=' + encodeURIComponent(search), true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(xhr.responseText, 'text/html');
                document.getElementById('userTable').innerHTML = doc.getElementById('userTable').innerHTML;
                document.querySelector('.card-footer').innerHTML = doc.querySelector('.card-footer').innerHTML;
            }
        };
        xhr.send();
    });
</script>

<?php
$content = ob_get_clean();
include("template.php");
?>
