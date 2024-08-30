<?php 
$edit = mysqli_query($koneksi,"SELECT * FROM tbl_siswa WHERE id_siswa='$_GET[id]' ");
foreach ($edit as $d) {
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
                <a href="#" style="color: white;">Edit Siswa</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9);">
                <div class="card-header d-flex align-items-center">
                    <h3 class="h4" style="color: white !important;">Form Edit Siswa</h3>
                </div>
                <div class="card-body">

                    <form action="?page=siswa&act=proses" method="post" enctype="multipart/form-data">
                        <input name="id" type="hidden" value="<?=$d['id_siswa'] ?>">

                        <table cellpadding="3" style="font-weight: bold; color: white;">
                            <tr>
                                <td>Nama Peserta Didik </td>
                                <td>:</td>
                                <td><input type="text" class="form-control" name="nama" value="<?=$d['nama'] ?>"
                                        required style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                                </td>
                            </tr>
                            <tr>
                                <td>NIS</td>
                                <td>:</td>
                                <td><input name="nis" type="text" class="form-control"
                                        style="background-color: rgba(36, 36, 44, 0.9); color: black;"
                                        value="<?=$d['nis'] ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin </td>
                                <td>:</td>
                                <td>
                                    <select name="jk" class="form-control"
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                                        <option value="L" <?= ($d['gender'] == 'L') ? 'selected' : ''; ?>>Laki-laki
                                        </option>
                                        <option value="P" <?= ($d['gender'] == 'P') ? 'selected' : ''; ?>>Perempuan
                                        </option>
                                    </select>

                                </td>
                            </tr>
                            <tr>
                                <td>Kelas Siswa</td>
                                <td>:</td>
                                <td>
                                    <select class="form-control" name="kelas"
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                                        <?php
                                        $sqlKelas=mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY kelas ASC");
                                        while($kelas=mysqli_fetch_array($sqlKelas)){

                                            if ($kelas['kelas']==$d['kelas']) {
                                                $selected= "selected";
                                            } else {
                                                $selected='';
                                            }
                                            echo "<option value='$kelas[kelas]' $selected>$kelas[kelas]</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Tahun Masuk</td>
                                <td>:</td>
                                <td><input name="th_masuk" class="form-control" value="<?=$d['angkatan'] ?>" required
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white;"></td>
                            </tr>

                            <tr>
                                <td colspan="3" style="text-align: right;">
                                    <button name="editSiswa" type="submit" class="btn btn-primary"><i
                                            class="fa fa-save"></i> Update</button>
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
<?php } ?>