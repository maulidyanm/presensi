<?php
// Simulasi data dari database
$jadwalHari = [
    ['hari_mengajar' => 1],
    ['hari_mengajar' => 2],
    ['hari_mengajar' => 3],
    ['hari_mengajar' => 4],
    ['hari_mengajar' => 5]
];

$hari = [
    1 => 'Senin',
    2 => 'Selasa',
    3 => 'Rabu',
    4 => 'Kamis',
    5 => 'Jumat'
];

$today = date('N'); // Mendapatkan hari ini (1 = Senin, 2 = Selasa, dst.)
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

td.actions {
    display: flex;
    flex-direction: row;
    gap: 5px;
    justify-content: center;
    align-items: center;
}

td.kelas,
td.guru {
    white-space: nowrap;
}

label {
    color: white !important;
}
</style>

<body>
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Jadwal</h4>
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
                    <a href="#">Jadwal Mengajar</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow" style="color: white;"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Daftar Jadwal Mengajar</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <a href="?page=jadwal&act=add" class="btn btn-primary btn-sm text-white"><i
                                    class="fa fa-plus"></i> Tambah</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive danger">
                            <table id="basic-datatables" class="display table table-dark table-hover"
                                style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Guru</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>Hari</th>
                                        <th>TP/Semester</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Assuming $conn is your mysqli connection object
                                        $no = 1;
                                        $query = "SELECT * FROM jadwal_pengajar
                                                    INNER JOIN kelas ON jadwal_pengajar.kelas = kelas.kelas
                                                    INNER JOIN tbl_staff ON jadwal_pengajar.id_staff = tbl_staff.id_staff
                                                    INNER JOIN mapel ON jadwal_pengajar.pelajaran = mapel.nama_buku
                                                    INNER JOIN semester ON jadwal_pengajar.semester = semester.status
                                                    INNER JOIN ajaran ON jadwal_pengajar.tahun = ajaran.tahun
                                                    ORDER BY jadwal_pengajar.kelas ASC";

                                        $result = mysqli_query($koneksi, $query);

                                        while ($d = mysqli_fetch_assoc($result)) {
                                            $today = date('N'); // Perbarui nilai hari ini di setiap iterasi
                                            $jadwal = '';
                                            if ($d['hari_mengajar'] == $today) {
                                                $jadwal = 'info';
                                            } elseif ($d['hari_mengajar'] > $today) {
                                                $jadwal = 'dark';
                                            } else {
                                                $jadwal = 'light';
                                            }
                                        ?>
                                    <tr>
                                        <td><b><?= $no++; ?>.</b></td>
                                        <td class="guru"><?= $d['nama']; ?></td>
                                        <td><?= $d['nama_buku']; ?></td>
                                        <td class="kelas"><?= $d['kelas']; ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $jadwal; ?> btn-sm">
                                                <?php echo $hari[$d['hari_mengajar']]; ?>
                                                <span id="countdown_<?php echo $d['id_jadwal']; ?>"></span>
                                            </span>
                                        </td>
                                        <td><?= $d['tahun'] . '/' . $d['status']; ?></td>
                                        <td class="actions">
                                            <a href="?page=jadwal&act=cancel&id=<?= $d['id_jadwal']; ?>"
                                                class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Batal</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Fungsi untuk menghitung countdown
    function hitungCountdown(targetDate, elementId) {
        var countDownDate = new Date(targetDate).getTime();

        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;

            if (distance < 0) {
                distance += 7 * 24 * 60 * 60 * 1000; // Tambahkan 7 hari dalam milidetik
            }

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (days === 0 && hours === 0 && minutes === 0 && seconds === 0) {
                document.getElementById(elementId).innerHTML = "Hari ini";
            } else {
                document.getElementById(elementId).innerHTML = days + "d " + hours + "h " +
                    minutes + "m " + seconds + "s ";
            }
        }, 1000);
    }

    // Panggil fungsi countdown saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        <?php
        // Reset result pointer to the beginning of the result set
        mysqli_data_seek($result, 0);

        // Loop through the result set to get the appropriate countdown targets
        while ($d = mysqli_fetch_assoc($result)) {
            $hariMengajar = $d['hari_mengajar'];
            $idJadwal = $d['id_jadwal'];
            echo "
                var targetDate_$idJadwal = new Date();
                targetDate_$idJadwal.setHours(0, 0, 0, 0);
                var targetDay_$idJadwal = $hariMengajar;
                var today = new Date().getDay();
                if (targetDay_$idJadwal == today) {
                    targetDate_$idJadwal.setDate(targetDate_$idJadwal.getDate());
                } else if (targetDay_$idJadwal > today) {
                    targetDate_$idJadwal.setDate(targetDate_$idJadwal.getDate() + (targetDay_$idJadwal - today));
                } else {
                    targetDate_$idJadwal.setDate(targetDate_$idJadwal.getDate() + (targetDay_$idJadwal - today + 7));
                }
                hitungCountdown(targetDate_$idJadwal, 'countdown_$idJadwal');
            ";
        }
        ?>
    });
    </script>
</body>