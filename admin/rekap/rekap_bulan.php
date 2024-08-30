<?php
include '../../koneksi/koneksi.php';
?>

<?php
// Lakukan koneksi ke database di sini

// Periksa apakah $_GET['pelajaran'] dan $_GET['kelas'] sudah diatur, jika tidak maka hentikan eksekusi dengan pesan yang sesuai

// Escape inputan $_GET untuk mencegah SQL injection
$pelajaran = mysqli_real_escape_string($koneksi, $_GET['pelajaran']);
$kelas = mysqli_real_escape_string($koneksi, $_GET['kelas']);
$bulan = mysqli_real_escape_string($koneksi, $_GET['bulan']);

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

// tampilkan data absen
$qry = mysqli_query($koneksi, "
    SELECT 
        t.id_siswa,
        s.nama,
        s.gender,
        t.tanggal_transaksi,
        t.tahun,
        t.semester,
        s.kelas  -- Assuming 'kelas' is the column name for class
    FROM 
        tbl_transaksi_hadir t
    INNER JOIN 
        tbl_siswa s 
    ON 
        t.id_siswa = s.id_siswa
        
    INNER JOIN (
        SELECT 
            id_siswa, 
            MAX(tanggal_transaksi) AS max_tanggal_transaksi
        FROM 
            tbl_transaksi_hadir
        WHERE 
            MONTH(tanggal_transaksi) = '$bulan'
        GROUP BY 
            id_siswa
    ) t2 
    ON 
        t.id_siswa = t2.id_siswa 
        AND t.tanggal_transaksi = t2.max_tanggal_transaksi
    WHERE
        s.kelas = '$kelas'  -- Filter by class
    ORDER BY 
        s.kelas ASC,   -- Sorting by class
        t.id_siswa ASC
");

foreach ($qry as $db) {
    // your code here
}

if (!$qry) {
    die('Query Error: ' . mysqli_error($koneksi));
}

foreach ($qry as $db) {
    // process each row
}




$tglBulan = $db['tanggal_transaksi'];
$tglTerakhir = date('t', strtotime($tglBulan));
?>
<style>
body {
    font-family: arial;
}

.kelas,
.tahun {
    white-space: nowrap;
}
</style>
<table width="100%">
    <tr>
        <td>
            <img src="../../admin/logo.png" width="130">
        </td>
        <td>
            <center>
                <h1>
                    ABSENSI SISWA <br>
                    <small> SMK 6 Surakarta</small>
                </h1>
                <hr>
                <em>
                    Jl. Adi Sucipto No.38, Kerten, Kec. Laweyan, Kota Surakarta, Jawa Tengah
                    57143
                    <br>Email : admin@smkn6solo.sch.id Telp.(0271)726036
                </em>
            </center>
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td colspan="2"><b class="kelas" style="border: 2px solid;padding: 7px;">
                            KELAS ( <?= strtoupper($d['kelas']) ?> )
                        </b> </td>
                    <td>
                        <b class="tahun" style="border: 2px solid;padding: 7px;">
                            <?= $d['semester'] ?> |
                            <?= $d['tahun'] ?>
                        </b>
                    </td>
                    <td rowspan="5">
                        <ul>
                            <li>S = Sakit</li>
                            <li>I = Izin</li>
                            <li>A = Absen</li>
                            <li>H = Hadir</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Nama Guru </td>
                    <td>:</td>
                    <td><?= $d['nama'] ?></td>
                </tr>
                <tr>
                    <td>Bidang Studi </td>
                    <td>:</td>
                    <td><?= $d['nama_buku'] ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<hr style="height: 3px;border: 1px solid;">

<table width="100%" border="1" cellpadding="2" style="border-collapse: collapse;">
    <tr>
        <td rowspan="2" bgcolor="#EFEBE9" align="center">NO</td>
        <td rowspan="2" bgcolor="#EFEBE9">NAMA SISWA</td>
        <td rowspan="2" bgcolor="#EFEBE9" align="center">L/P</td>
        <td colspan="<?= $tglTerakhir; ?>" style="padding: 8px;">PERTEMUAN BULAN : <b
                style="text-transform: uppercase;"><?php echo namaBulan($bulan); ?>
                <?= date('Y', strtotime($tglBulan)); ?></b></td>
        <td colspan="5" align="center" bgcolor="#EFEBE9">JUMLAH</td>
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
    // tampilkan absen siswa
    $no = 1;
    foreach ($qry as $ds) {
        $warna = ($no % 2 == 1) ? "#ffffff" : "#f0f0f0";
        ?>
    <tr bgcolor="<?= $warna; ?>">
        <td align="center"><?= $no++; ?></td>
        <td><?= $ds['nama']; ?></td>
        <td align="center"><?= $ds['gender']; ?></td>
        <?php
            for ($i = 1; $i <= $tglTerakhir; $i++) {
                ?>
        <td align="center" bgcolor="white">
            <?php
                    $ket = mysqli_query($koneksi, "
    SELECT 
        MAX(tbl_transaksi_hadir.status) AS status 
    FROM 
        tbl_transaksi_hadir
    INNER JOIN 
        semester ON tbl_transaksi_hadir.semester = semester.status
    INNER JOIN 
        ajaran ON tbl_transaksi_hadir.tahun = ajaran.tahun
    INNER JOIN 
        tbl_siswa ON tbl_transaksi_hadir.id_siswa = tbl_siswa.id_siswa
    INNER JOIN 
        tbl_staff ON tbl_transaksi_hadir.id_staff = tbl_staff.id_staff
    WHERE 
        DAY(tbl_transaksi_hadir.tanggal_transaksi) = '$i' 
    AND 
        tbl_transaksi_hadir.id_siswa = '$ds[id_siswa]' 
    AND 
        MONTH(tbl_transaksi_hadir.tanggal_transaksi) = '$bulan' 
    AND 
        tbl_siswa.kelas = '$_GET[kelas]' 
    AND 
        tbl_staff.id_staff = '$_GET[guru]' 
    AND 
        ajaran.aktif = 1 
    AND 
        semester.aktif = 1 
    GROUP BY 
        DAY(tbl_transaksi_hadir.tanggal_transaksi)
");

                    foreach ($ket as $h) {
                        if ($h['status'] == 'H') {
                            echo "<b style='color:#2196F3;'>H</b>";
                        } elseif ($h['status'] == 'I') {
                            echo "<b style='color:#4CAF50;'>I</b>";
                        } elseif ($h['status'] == 'S') {
                            echo "<b style='color:#FFC107;'>S</b>";
                        } elseif ($h['status'] == 'A') {
                            echo "<b style='color:#D50000;'>A</b>";
                        } elseif ($h['status'] == 'T') {
                            echo "<b style='color:#76FF03;'>T</b>";
                        } else {
                            echo "<b style='color:#9C27B0;'>C</b>";
                        }
                    }
                    ?>


        </td>
        <?php
            }
            ?>
        <td align="center" style="font-weight: bold;">
            <?php
                $sakit = mysqli_fetch_array(mysqli_query($koneksi, "
        SELECT COUNT(keterangan) AS sakit 
        FROM tbl_transaksi_hadir
        INNER JOIN semester ON tbl_transaksi_hadir.semester = semester.status
        INNER JOIN ajaran ON tbl_transaksi_hadir.tahun = ajaran.tahun
        INNER JOIN tbl_staff ON tbl_transaksi_hadir.id_staff = tbl_staff.id_staff
        WHERE tbl_transaksi_hadir.id_siswa='$ds[id_siswa]' 
        AND tbl_transaksi_hadir.status='S' 
        AND tbl_transaksi_hadir.id_staff='$_GET[guru]' 
        AND MONTH(tanggal_transaksi)='$bulan' 
        AND ajaran.aktif=1 
        AND semester.aktif=1
    "));
                echo $sakit['sakit'];
                ?>
        </td>
        <td align="center" style="font-weight: bold;">
            <?php
                $izin = mysqli_fetch_array(mysqli_query($koneksi, "
        SELECT COUNT(keterangan) AS izin
        FROM tbl_transaksi_hadir
        INNER JOIN semester ON tbl_transaksi_hadir.semester = semester.status
        INNER JOIN ajaran ON tbl_transaksi_hadir.tahun = ajaran.tahun
        INNER JOIN tbl_staff ON tbl_transaksi_hadir.id_staff = tbl_staff.id_staff
        WHERE tbl_transaksi_hadir.id_siswa='$ds[id_siswa]' 
        AND tbl_transaksi_hadir.status='I' 
        AND tbl_transaksi_hadir.id_staff='$_GET[guru]' 
        AND MONTH(tanggal_transaksi)='$bulan' 
        AND ajaran.aktif=1 
        AND semester.aktif=1
    "));
                echo $izin['izin'];
                ?>
        </td>
        <td align="center" style="font-weight: bold;">
            <?php
                $alfa = mysqli_fetch_array(mysqli_query($koneksi, "
        SELECT COUNT(keterangan) AS alfa
        FROM tbl_transaksi_hadir
        INNER JOIN semester ON tbl_transaksi_hadir.semester = semester.status
        INNER JOIN ajaran ON tbl_transaksi_hadir.tahun = ajaran.tahun
        INNER JOIN tbl_staff ON tbl_transaksi_hadir.id_staff = tbl_staff.id_staff
        WHERE tbl_transaksi_hadir.id_siswa='$ds[id_siswa]' 
        AND tbl_transaksi_hadir.status='A' 
        AND tbl_transaksi_hadir.id_staff='$_GET[guru]' 
        AND MONTH(tanggal_transaksi)='$bulan' 
        AND ajaran.aktif=1 
        AND semester.aktif=1
    "));
                echo $alfa['alfa'];
                ?>
        </td>
        <td align="center" style="font-weight: bold;">
            <?php
                $hadir = mysqli_fetch_array(mysqli_query($koneksi, "
        SELECT COUNT(keterangan) AS hadir
        FROM tbl_transaksi_hadir
        INNER JOIN semester ON tbl_transaksi_hadir.semester = semester.status
        INNER JOIN ajaran ON tbl_transaksi_hadir.tahun = ajaran.tahun
        INNER JOIN tbl_staff ON tbl_transaksi_hadir.id_staff = tbl_staff.id_staff
        WHERE tbl_transaksi_hadir.id_siswa='$ds[id_siswa]' 
        AND tbl_transaksi_hadir.status='H' 
        AND tbl_transaksi_hadir.id_staff='$_GET[guru]' 
        AND MONTH(tanggal_transaksi)='$bulan' 
        AND ajaran.aktif=1 
        AND semester.aktif=1
    "));
                echo $hadir['hadir'];
                ?>
        </td>


    </tr>
    <?php } ?>
</table>

<p></p>
<table width="100%">
    <tr>
        <td align="right">
            <p>
                Surakarta, <?php echo date('d F Y'); ?>
            </p>
            <p>
                Kepala Sekolah
                <br>
                <br>
                <br>
                <br>
                <br>
                Dwi Titik Indiyanti,S.Si,M.Pd. <br>
                ---------------------------------------<br>
                NIP.19710423 200501 2 006
            </p>
        </td>
    </tr>
</table>

<script>
window.print();
</script>