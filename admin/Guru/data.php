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

label {
    color: white !important;
}



th.kode {
    white-space: nowrap;
}
</style>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title" style="color: white;">Guru</h4>
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
                <a href="#" style="color: white;">Data Guru</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a href="#" style="color: white;">Daftar Guru</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9);">
                <div class="card-header">
                    <div class="card-title">
                        <a href="?page=guru&act=add" class="btn btn-primary btn-sm text-white"><i
                                class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="basic-datatables" class="table table-hover table-dark"
                            style="color: white; text-align: center;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class=" kode">Kode Guru</th>
                                    <th>Nama Guru</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Foto</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                        $no=1;
                        $guru = mysqli_query($koneksi,"SELECT * FROM tbl_staff");
                        foreach ($guru as $g) {?>
                                <tr>
                                    <td><?=$no++;?>.</td>

                                    <td><?=$g['id_staff'];?></td>
                                    <td class="nama"><?=$g['nama'];?></td>
                                    <td><?=$g['email'];?></td>
                                    <td><?php if ($g['status']=='Y') {
                                echo "<span class='badge badge-success'>Aktif</span>";
                                
                            }else {
                                echo "<span class='badge badge-danger'>Off</span>";
                            } ?></td>
                                    <td><img src="../admin/photo-profiles/<?=$data['profiles'] ?>" width="45"
                                            height="45">
                                    </td>
                                    <td class="actions">
                                        <a class="btn btn-info btn-sm"
                                            href="?page=guru&act=edit&id=<?=$g['id_staff'] ?>"><i
                                                class="far fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin Hapus Data dari [<?=$g['id_staff']?>] <?= $g['nama'] ?>??')"
                                            href="?page=guru&act=del&id=<?=$g['id_staff'] ?>"><i
                                                class="fas fa-trash"></i>
                                        </a>

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