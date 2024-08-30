<style>
/* Atur tata letak flex dan arah flex menjadi baris (horizontal) */
td.actions {
    display: flex;
    flex-direction: row;
    gap: 5px;
    /* Jarak antara tombol */
    justify-content: center;
    /* Pusatkan item secara horizontal */
    align-items: center;
    /* Pusatkan item secara vertikal */
}

/* Atur agar teks dalam sel td dengan kelas "nama" atau "kelas" tidak melakukan wrapping */
td.kelas {
    white-space: nowrap;
}

th.masuk {
    white-space: nowrap;
}

label {
    color: white !important;
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
        <div class="col-md-12">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9);">
                <div class="card-header">
                    <div class="card-title">
                        <a href="?page=siswa&act=add" class="btn btn-primary btn-sm text-white"><i
                                class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="table table-hover table-dark table"
                            style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas </th>
                                    <th class="masuk">Tahun Masuk</th>
                                    <th>Kelamin</th>
                                    <th>Status</th>

                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                        $no=1;
            $siswa = mysqli_query($koneksi, "SELECT * FROM tbl_siswa 
                                  INNER JOIN kelas ON tbl_siswa.kelas=kelas.kelas");
foreach ($siswa as $g) {
     // Menentukan jenis kelamin
    $gender = '';
    if ($g['gender'] == 'L') {
        $gender = 'laki-laki';
    } elseif ($g['gender'] == 'P') {
        $gender = 'perempuan';
    } else {
        $gender = 'gender tidak dikenali';
    }
?>
                                <tr>
                                    <td><?=$no++;?>.</td>
                                    <td><?=$g['nis'];?></td>
                                    <td><?=$g['nama'];?></td>
                                    <td class="kelas"><?=$g['kelas'];?></td>
                                    <!-- Menggunakan kolom 'nama_kelas' dari tabel kelas -->
                                    <td><?=$g['angkatan'];?></td>
                                    <td><?=$gender;?></td>
                                    <td><?php if ($g['status'] == 'Y') {
            echo "<span class='badge badge-success'>Aktif</span>";
        } else {
            echo "<span class='badge badge-danger'>Off</span>";
        } ?></td>

                                    <td class="actions">
                                        <a class="btn btn-info btn-sm"
                                            href="?page=siswa&act=edit&id=<?=$g['id_siswa'] ?>"><i
                                                class="far fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin Hapus Data dari <?= $g['nama'] ?>??')"
                                            href="?page=siswa&act=del&id=<?= $g['id_siswa'] ?>"><i
                                                class="fas fa-trash"></i></a>

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
</div>
</div>