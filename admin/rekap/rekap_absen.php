<?php
// Assuming $koneksi is your database connection variable

// Check if id_kelas is provided
if(isset($_GET['id_kelas'])) {
    // Sanitize id_kelas to prevent SQL Injection
    $id_kelas = mysqli_real_escape_string($koneksi, $_GET['id_kelas']);

    $nama_kelas = $id_kelas;

    // Perform the query to get teaching information
    $query = "SELECT * FROM jadwal_pengajar 
            INNER JOIN kelas ON jadwal_pengajar.kelas = kelas.kelas
            INNER JOIN tbl_staff ON jadwal_pengajar.id_staff = tbl_staff.id_staff
            INNER JOIN mapel ON jadwal_pengajar.pelajaran = mapel.nama_buku
            INNER JOIN semester ON jadwal_pengajar.semester = semester.status
            INNER JOIN ajaran ON jadwal_pengajar.tahun = ajaran.tahun
            WHERE jadwal_pengajar.kelas=? AND ajaran.aktif=1 AND semester.aktif=1
            ORDER BY jadwal_pengajar.jenis_jadwal ASC"; // Menambahkan klausa ORDER BY
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $id_kelas);
    mysqli_stmt_execute($stmt);
    $kelasMengajar = mysqli_stmt_get_result($stmt);

    // Check if the query was successful
    if ($kelasMengajar) {
        // Fetch associative array
        $dataKelasMengajar = mysqli_fetch_all($kelasMengajar, MYSQLI_ASSOC);

        // Display the class name
        $kelasText = "";
        if (!empty($nama_kelas)) {
            $kelasText = "KELAS " . strtoupper($nama_kelas); // Menggabungkan "KELAS" dengan nama kelas
        } else {
            $kelasText = "Data kelas tidak ditemukan";
        }

        ?>
<style>
.breadcrumbs li a {
    color: white;
}

.page-title {
    color: white;
}

.card {
    background-color: rgba(36, 36, 44, 0.9);
}

.guru {
    white-space: nowrap;
}
</style>
<!-- HTML structure -->
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Rekap Absen</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="main.php">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a href="#">
                    <?= $kelasText ?>
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Menggunakan class .table-responsive untuk membuat tabel responsif -->
                        <table class="table table-dark table-hover table-xs"
                            style="text-align: center; white-space: nowrap;">
                            <!-- Menambahkan white-space: nowrap; untuk mencegah pemotongan teks -->
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th>Kode Pelajaran</th>
                                    <th scopre="col">Jadwal</th>
                                    <th scope="col">Mata Pelajaran</th>
                                    <th scope="col">Absensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Iterate over the fetched data to display teaching information
                                $no = 1;
                                foreach ($dataKelasMengajar as $mp) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?>.</td>
                                    <td>KP - <?= str_pad($mp['id_jadwal'], 3, '0', STR_PAD_LEFT); ?></td>
                                    <td><?= $mp['jenis_jadwal']; ?></td>
                                    <td>
                                        <b><?= $mp['nama_buku']; ?></b><br>
                                        <code class="guru"><?= $mp['nama']; ?></code>
                                    </td>
                                    <td>
                                        <a href="?page=rekap&act=rekap-perbulan&pelajaran=<?= $mp['id_jadwal'] ?>&kelas=<?= $_GET['id_kelas'] ?>&guru=<?= $mp['id_staff']?>"
                                            class="btn btn-default">
                                            <span class="btn-label">
                                                <i class="fas fa-clipboard"></i>
                                            </span>
                                            Rekap Absen
                                        </a>
                                    </td>

                                </tr>
                                <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
    } else {
        // Query failed
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // id_kelas is not provided
    echo "Parameter id_kelas tidak ditemukan";
}
?>