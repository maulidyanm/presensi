<?php 
if ($koneksi) {
    $query_max_nis = mysqli_query($koneksi, "SELECT MAX(nis) AS max_nis FROM tbl_siswa");
    $data_max_nis = mysqli_fetch_assoc($query_max_nis);
    
    // Tambahkan satu ke NIS tertinggi
    $nis_tertinggi = $data_max_nis['max_nis'] + 1;
}
?>
<style>
/* Atur lebar tabel */
table {
    width: 100%;
    /* Atur lebar tabel agar sama dengan lebar container */
}

/* Atur lebar input fields */
input[type="text"],
select {
    width: 100%;
    /* Atur lebar input fields agar merentang di seluruh lebar tabel */
}
</style>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title" style="color: white;">Siswa</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="main.php">
                    <i class="flaticon-home" style="color: white;"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a href="#" style="color: white;">Data Siswa</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a href="#" style="color: white;">Tambah Siswa</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                <div class="card-header d-flex align-items-center">
                    <h3 class="h4">Tambah Siswa</h3>
                </div>
                <div class="card-body">
                    <form action="?page=siswa&act=proses" method="post" enctype="multipart/form-data">

                        <table cellpadding="3" style="font-weight: bold;">
                            <tr>
                                <td>Nama Peserta Didik </td>
                                <td>:</td>
                                <td><input type="text" class="form-control" name="nama" placeholder="Nama lengkap"
                                        required style="background-color: rgba(36, 36, 44, 0.9); color: white;"></td>
                            </tr>
                            <tr>
                                <td>NIS</td>
                                <td>:</td>
                                <td>
                                    <input name="nis" type="text" class="form-control" placeholder="NIS" readonly
                                        style="background-color: rgba(36, 36, 44, 0.9); color: black;"
                                        value="<?php echo isset($nis_tertinggi) ? $nis_tertinggi : ''; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin </td>
                                <td>:</td>
                                <td>
                                    <select name="jk" class="form-control" required
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Kelas Siswa</td>
                                <td>:</td>
                                <td>
                                    <select class="form-control" name="kelas" required
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                                        <option value="">Pilih Kelas</option>
                                        <?php
                    $sqlKelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY id_kelas ASC");
                    while ($kelas = mysqli_fetch_array($sqlKelas)) {
                        echo "<option value='$kelas[kelas]'>$kelas[kelas]</option>";
                    }
                    ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Tahun Masuk</td>
                                <td>:</td>
                                <td><input type="number" id="year" name="th_masuk" min="<?php echo date("Y") -15; ?>"
                                        max="<?php echo date("Y"); ?>" step="1" class="form-control"
                                        placeholder="<?php echo date("Y"); ?>" required
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white;"></td>
                            </tr>

                            <tr>
                                <td colspan="3" style="text-align: right;">
                                    <button name="saveSiswa" type="submit" class="btn btn-primary"><i
                                            class="fa fa-save"></i> Simpan
                                    </button>
                                    <a href="javascript:history.back()" class="btn btn-warning"><i
                                            class="fa fa-chevron-left"></i> Batal</a>
                                </td>
                            </tr>
                        </table>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>