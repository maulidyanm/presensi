<?php
$taAktif = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ajaran WHERE aktif=1"));
$semAktif = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM semester WHERE aktif=1"));

// Query to get the highest id_tertinggi from the database
$query_highest_id = mysqli_query($koneksi, "SELECT MAX(id_jadwal) AS max_id FROM jadwal_pengajar");
$row_highest_id = mysqli_fetch_assoc($query_highest_id);
$id_tertinggi = ($row_highest_id['max_id'] >= 215) ? ($row_highest_id['max_id'] + 1) : 215;





if (isset($_POST['save'])) {
$kode = $_POST['kode'];
$ta = $taAktif['tahun'];
$semester = $semAktif['status'];
$guru = $_POST['guru'];
$mapel = $_POST['mapel'];
// Pisahkan nilai menjadi bagian-bagian
list($nama_buku, $jenis) = explode('|', $mapel);
$hari = $_POST['hari'];
$kelas = $_POST['kelas'];
$jamawl = $_POST['jamawl'];
$jamahr = $_POST['jamahr'];

// Prepared statement untuk memasukkan data ke dalam tabel mengajar
$stmt = $koneksi->prepare("INSERT INTO jadwal_pengajar (id_jadwal, jenis_jadwal, id_staff, hari_mengajar,
mulai_mengajar, akhir_mengajar, kelas, pelajaran, semester, tahun)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ? ,?)");
$stmt->bind_param("ississssss",$kode, $jenis, $guru, $hari, $jamawl, $jamahr, $kelas, $nama_buku, $semester, $ta);
$stmt->execute();

if ($stmt->affected_rows > 0) {
echo "
<script type='text/javascript'>
setTimeout(function() {
    alert('Jadwal ditambahkan');
    window.location.replace('?page=jadwal');
}, 100);
</script>";
} else {
// Penanganan error jika query tidak berhasil dieksekusi
echo "Error: " . $stmt->error;
}

$stmt->close();
}

?>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title" style="color: white;">Tambah Jadwal Mengajar</h4>
        <ul class="breadcrumbs" style="color: white;">
            <li class="nav-home">
                <a href="main.php" style="color: white;">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator" style="color: white;">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item" style="color: white;">
                <a href="#" style="color: white;">Jadwal</a>
            </li>
            <li class="separator" style="color: white;">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item" style="color: white;">
                <a href="#" style="color: white;">Jadwal Mengajar</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9);">
                <div class="card-header">
                    <h4 class="card-title" style="color: white !important;">Form Jadwal</h4>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kode" style="color: white !important;">Kode Pelajaran</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark2 bg-gradient" id="basic-addon1"
                                                style="color:gray;">KP
                                                -</span>
                                        </div>
                                        <input name="kode" type="text" class="form-control" id="kode"
                                            value="<?php echo isset($id_tertinggi) ? htmlspecialchars($id_tertinggi) : ''; ?>"
                                            readonly>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="color: white !important;">Tahun Pelajaran</label>
                                    <input type="text" class="form-control" value="<?=$taAktif['tahun']?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kode" style="color: white !important;">Semester</label>
                                    <input type="text" class="form-control" value="<?=$semAktif['status']?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: white !important;">Guru Mata Pelajaran</label>
                                    <select name="guru" class="form-control" required>
                                        <option value="">- Pilih -</option>
                                        <?php 
                                            $guru = mysqli_query($koneksi, "SELECT * FROM tbl_staff ORDER BY id_staff ASC");
                                            foreach ($guru as $g) {
                                                echo "<option value='$g[id_staff]'>[$g[id_staff]] $g[nama]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: white !important;">Mata Pelajaran</label>
                                    <select name="mapel" class="form-control" required>
                                        <option value="">- Pilih -</option>
                                        <?php 
                                            $mapel = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY id ASC");
                                            foreach ($mapel as $g) {
                                                echo "<option value='$g[nama_buku]|$g[jenis]'>[ $g[id_buku]-$g[jenis] ] $g[nama_buku]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari" style="color: white !important;">Hari</label>
                                    <select class="form-control" id="hari" name="hari" required>
                                        <option value="">- Pilih -</option>
                                        <option value="1" data-value="Senin">Senin</option>
                                        <option value="2" data-value="Selasa">Selasa</option>
                                        <option value="3" data-value="Rabu">Rabu</option>
                                        <option value="4" data-value="Kamis">Kamis</option>
                                        <option value="5" data-value="Jum'at">Jumat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="color: white !important;">Kelas</label>
                                    <select name="kelas" class="form-control" required>
                                        <option value="">- Pilih -</option>
                                        <?php 
                                            $kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY id_kelas ASC");
                                            foreach ($kelas as $g) {
                                                echo "<option value='$g[kelas]'>$g[kelas]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jamawl" style="color: white !important;">Jam Awal</label>
                                    <input name="jamawl" type="time" class="form-control" id="waktu" placeholder="00.00"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jamahr" style="color: white !important;">Jam Akhir</label>
                                    <input name="jamahr" type="time" class="form-control" id="jamke" placeholder="00.00"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" name="save" class="btn btn-secondary">
                                        <i class="far fa-save"></i> Simpan
                                    </button>
                                    <a href="javascript:history.back()" class="btn btn-danger">
                                        <i class="fas fa-angle-double-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>

                    </form>
                    <?php
                    
                ?>
                </div>
            </div>
        </div>
    </div>
</div>