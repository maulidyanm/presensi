<?php
// Lakukan koneksi ke database di sini

// Periksa apakah $_GET['pelajaran'] dan $_GET['kelas'] sudah diatur, jika tidak maka hentikan eksekusi dengan pesan yang sesuai

// Escape inputan $_GET untuk mencegah SQL injection
$pelajaran = mysqli_real_escape_string($koneksi, $_GET['pelajaran']);
$kelas = mysqli_real_escape_string($koneksi, $_GET['kelas']);

// Ubah kueri untuk menghindari SQL injection dan memperbaiki query untuk menghindari pengulangan koneksi
$kelasMengajarQuery = "
    SELECT * FROM jadwal_pengajar 
    
    INNER JOIN kelas ON jadwal_pengajar.kelas = kelas.kelas
    INNER JOIN tbl_staff ON jadwal_pengajar.id_staff = tbl_staff.id_staff
    INNER JOIN mapel ON jadwal_pengajar.pelajaran = mapel.nama_buku
    INNER JOIN semester ON jadwal_pengajar.semester = semester.status
    INNER JOIN ajaran ON jadwal_pengajar.tahun = ajaran.tahun
    WHERE jadwal_pengajar.id_jadwal = '$pelajaran'
    AND jadwal_pengajar.kelas = '$kelas'
    AND ajaran.aktif = 1
    AND semester.aktif = 1
";

$kelasMengajar = mysqli_query($koneksi, $kelasMengajarQuery);

if (!$kelasMengajar) {
    die('Query Error: ' . mysqli_error($koneksi));
}

$d = mysqli_fetch_assoc($kelasMengajar);
// Penanganan ketika tidak ada hasil ditemukan harus ditambahkan

$nama_kelas = isset($d['kelas']) ? strtoupper($d['kelas']) : 'KELAS TIDAK DITEMUKAN';
$mapel = isset($d['nama_buku']) ? strtoupper($d['nama_buku']) : 'MAPEL TIDAK DITEMUKAN';
$semester = isset($d['semester']) ? strtoupper($d['semester']) : 'SEMESTER TIDAK DITEMUKAN';
$tahun_ajaran = isset($d['tahun']) ? strtoupper($d['tahun']) : 'TAHUN AJARAN TIDAK DITEMUKAN';
$nama_guru = isset($d['nama']) ? $d['nama'] : 'NAMA GURU TIDAK DITEMUKAN';
?>
<div class="page-inner">
    <style>
    .breadcrumbs li a {
        color: white;
    }

    .page-title,
    .separator {
        color: white;
    }

    .kelas,
    .tahun {
        white-space: nowrap;
    }
    </style>
    <div class="page-header">
        <h4 class="page-title"><?= htmlspecialchars($mapel) ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="main.php">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">KELAS (<?= htmlspecialchars($nama_kelas) ?>)</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="card">
                <div class="card-header" style="overflow-x: auto;">
                    <table width="100%">
                        <tr>
                            <td>
                                <img src="logo.png" width="130">
                            </td>
                            <td>
                                <h1>
                                    ABSENSI SISWA <br>
                                    <small>SMKN 6 SURAKARTA</small>
                                    <br><small>Jl. Adi Sucipto No.38, Kerten, Kec. Laweyan, Kota Surakarta, Jawa Tengah
                                        57143
                                        <br>Email : admin@smkn6solo.sch.id Telp.(0271)726036</small>
                                </h1>
                            </td>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td colspan="2">
                                            <b class="kelas" style="border: 2px solid; padding: 7px;">
                                                KELAS (<?= htmlspecialchars($nama_kelas) ?>)
                                            </b>
                                        </td>
                                        <td>
                                            <b class="tahun" style="border: 2px solid; padding: 7px;">
                                                <?= htmlspecialchars($semester) ?> |
                                                <?= htmlspecialchars($tahun_ajaran) ?>
                                            </b>
                                        </td>
                                        <td rowspan="5">
                                            <p class="text-info">H = Hadir</p>
                                            <p class="text-success">I = Izin</p>
                                            <p class="text-warning">S = Sakit</p>
                                            <p class="text-danger">A = Absen</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Guru</td>
                                        <td>:</td>
                                        <td><?= htmlspecialchars($nama_guru) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pelajaran</td>
                                        <td>:</td>
                                        <td><?= htmlspecialchars($d['nama_buku']) ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-body">
                    <?php

                    // Ensure $_GET['guru'] is set and not empty
                    if (!isset($_GET['guru']) || empty($_GET['guru'])) {
                        die('Parameter guru is missing or empty!');
                    }

                    // Ensure $_GET['guru'] is properly sanitized
                    $guru = mysqli_real_escape_string($koneksi, $_GET['guru']);

                    $qry = mysqli_query($koneksi, "
        SELECT MONTH(tanggal_transaksi) AS bulan_transaksi, MAX(tbl_transaksi_hadir.status) AS status
        FROM tbl_transaksi_hadir 
        WHERE tbl_transaksi_hadir.id_staff = '$guru' 
        GROUP BY bulan_transaksi 
        ORDER BY bulan_transaksi DESC
    ");

                    if (!$qry) {
                        die('Query Error: ' . mysqli_error($koneksi));
                    }

                    while ($bulan = mysqli_fetch_assoc($qry)) {
                        $bulanNum = $bulan['bulan_transaksi'];
                        $tglBulan = mktime(0, 0, 0, $bulanNum, 1, date('Y')); // Set the day to 1st of the month
                        $tglTerakhir = date('t', $tglBulan); // Get the last day of the month
                        ?>

                    <div class="alert alert-warning alert-dismissible mt-2" role="alert">
                        <b class="text-warning" style="text-transform: uppercase;">BULAN <?= namaBulan($bulanNum); ?>
                            <?= date('Y') ?></b>
                        <hr>
                        <p>
                            <a target="_blank"
                                href="../admin/rekap/rekap_bulan.php?pelajaran=<?= urlencode($pelajaran) ?>&bulan=<?= urlencode($bulanNum) ?>&kelas=<?= urlencode($kelas) ?>&guru=<?= urlencode($_GET['guru']) ?>"
                                class="btn btn-default">
                                <span class="btn-label">
                                    <i class="fas fa-print"></i>
                                </span>
                                CETAK BULAN (<?= strtoupper(namaBulan($bulanNum)); ?>)
                            </a>
                        </p>
                        <div style="overflow-x: auto;">
                            <table class="responsive-table" width="100%" border="1" cellpadding="2"
                                style="border-collapse: collapse;">
                                <tr>
                                    <td rowspan="2" bgcolor="#EFEBE9" align="center">NO</td>
                                    <td rowspan="2" bgcolor="#EFEBE9">NAMA SISWA</td>
                                    <td rowspan="2" bgcolor="#EFEBE9" align="center">L/P</td>
                                    <td colspan="<?= $tglTerakhir; ?>" style="padding: 8px;">PERTEMUAN BULAN : <b
                                            style="text-transform: uppercase;"><?= namaBulan($bulanNum); ?>
                                            <?= date('Y', strtotime('today')); ?>
                                        </b></td>
                                    <td colspan="4" align="center" bgcolor="#EFEBE9">JUMLAH</td>
                                </tr>
                                <tr>
                                    <?php
                                        for ($i = 1; $i <= $tglTerakhir; $i++) {
                                            echo "<td bgcolor='#EFEBE9' align='center'>" . $i . "</td>";
                                        }
                                        ?>
                                    <td bgcolor="#FFC107" align="center">S</td>
                                    <td bgcolor="#4CAF50" align="center">I</td>
                                    <td bgcolor="#D50000" align="center">A</td>
                                    <td bgcolor="#2196F3" align="center">H</td>
                                </tr>
                                <?php
                                    // Display student attendance
                                    $no = 1;
                                    $qryAbsen = mysqli_query($koneksi, "
    SELECT tbl_transaksi_hadir.id_siswa, tbl_siswa.nama, tbl_siswa.gender, MAX(tbl_transaksi_hadir.status) AS status
    FROM tbl_transaksi_hadir
    INNER JOIN tbl_siswa ON tbl_transaksi_hadir.id_siswa = tbl_siswa.id_siswa
    WHERE MONTH(tbl_transaksi_hadir.tanggal_transaksi) = '$bulanNum'
    AND tbl_transaksi_hadir.id_staff = '" . $_GET['guru'] . "'
    GROUP BY tbl_transaksi_hadir.id_siswa, tbl_siswa.nama, tbl_siswa.gender
    ORDER BY tbl_transaksi_hadir.id_siswa ASC
");



                                    if (!$qryAbsen) {
                                        die('Query Error: ' . mysqli_error($koneksi));
                                    }

                                    while ($d = mysqli_fetch_assoc($qryAbsen)) {
                                        $warna = ($no % 2 == 1) ? "#ffffff" : "#f0f0f0";
                                        ?>
                                <tr bgcolor="<?= htmlspecialchars($warna); ?>">
                                    <td align="center"><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($d['nama']); ?></td>
                                    <td align="center"><?= htmlspecialchars($d['gender']); ?></td>
                                    <?php
                                            for ($i = 1; $i <= $tglTerakhir; $i++) {
                                                echo '<td align="center" bgcolor="white">';
                                                $ketQuery = "
    SELECT DAY(tanggal_transaksi) AS tanggal_transaksi, MAX(tbl_transaksi_hadir.status) AS status
    FROM tbl_transaksi_hadir
    WHERE DAY(tanggal_transaksi) = '$i'
    AND id_siswa = '" . $d['id_siswa'] . "' 
    AND id_staff = '" . $_GET['guru'] . "'
    AND MONTH(tanggal_transaksi) = '$bulanNum'
    GROUP BY DAY(tanggal_transaksi)
";


                                                $ket = mysqli_query($koneksi, $ketQuery);

                                                if (!$ket) {
                                                    die('Query Error: ' . mysqli_error($koneksi));
                                                }

                                                while ($h = mysqli_fetch_assoc($ket)) {
                                                    $total_transaksi = $h['status'];
                                                    // Memastikan bahwa output sesuai dengan nilai total_transaksi
                                                    switch ($total_transaksi) {
                                                        case 'A':
                                                            echo "<b style='color:#D50000;'>A</b>"; // Absen
                                                            break;
                                                        case 'H':
                                                            echo "<b style='color:#2196F3;'>H</b>"; // Hadir
                                                            break;
                                                        case 'I':
                                                            echo "<b style='color:#4CAF50;'>I</b>"; // Izin
                                                            break;
                                                        case 'S':
                                                            echo "<b style='color:#FFC107;'>S</b>"; // Sakit
                                                            break;
                                                        default:
                                                            echo "<b style='color:#D50000;'>L</b>"; // Lainnya
                                                    }
                                                }


                                                echo '</td>';


                                            }
                                            ?>
                                    <td align="center" style="font-weight: bold;">
                                        <?php
                                                $sakitQuery = "
    SELECT COUNT(t.status) AS sakit 
    FROM tbl_transaksi_hadir t
    JOIN jadwal_pengajar j 
    WHERE t.id_siswa = '" . $d['id_siswa'] . "'
    AND t.status = 'S'
    AND t.id_staff = '" . $_GET['guru'] . "'
    AND j.id_jadwal = '$pelajaran'
    AND MONTH(t.tanggal_transaksi) = '$bulanNum'
";
                                                $sakit = mysqli_fetch_array(mysqli_query($koneksi, $sakitQuery));
                                                echo $sakit['sakit'];
                                                ?>

                                    </td>
                                    <td align="center" style="font-weight: bold;">
                                        <?php
                                                $izinQuery = "
                                        SELECT COUNT(t.status) AS izin
    FROM tbl_transaksi_hadir t
    JOIN jadwal_pengajar j 
    WHERE t.id_siswa = '" . $d['id_siswa'] . "'
    AND t.status = 'I'
    AND t.id_staff = '" . $_GET['guru'] . "'
    AND j.id_jadwal = '$pelajaran'
    AND MONTH(t.tanggal_transaksi) = '$bulanNum'
                                    ";
                                                $izin = mysqli_fetch_array(mysqli_query($koneksi, $izinQuery));
                                                echo $izin['izin'];
                                                ?>
                                    </td>
                                    <td align="center" style="font-weight: bold;">
                                        <?php
                                                $alfaQuery = "
                                        SELECT COUNT(t.status) AS alfa
    FROM tbl_transaksi_hadir t
    JOIN jadwal_pengajar j 
    WHERE t.id_siswa = '" . $d['id_siswa'] . "'
    AND t.status = 'A'
    AND t.id_staff = '" . $_GET['guru'] . "'
    AND j.id_jadwal = '$pelajaran'
    AND MONTH(t.tanggal_transaksi) = '$bulanNum'
                                    ";
                                                $alfa = mysqli_fetch_array(mysqli_query($koneksi, $alfaQuery));
                                                echo $alfa['alfa'];
                                                ?>
                                    </td>
                                    <td align="center" style="font-weight: bold;">
                                        <?php
                                                $hadirQuery = "
                                       SELECT COUNT(t.status) AS hadir
    FROM tbl_transaksi_hadir t
    JOIN jadwal_pengajar j 
    WHERE t.id_siswa = '" . $d['id_siswa'] . "'
    AND t.status = 'H'
    AND t.id_staff = '" . $_GET['guru'] . "'
    AND j.id_jadwal = '$pelajaran'
    AND MONTH(t.tanggal_transaksi) = '$bulanNum'
                                    ";
                                                $hadir = mysqli_fetch_array(mysqli_query($koneksi, $hadirQuery));
                                                echo $hadir['hadir'];
                                                ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>