<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title text-white">Tahun Pelajaran</h4>
        <ul class="breadcrumbs text-white">
            <li class="nav-home">
                <a href="main.php" style="color: white;">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator" style="color: white;">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item" style="color: white;">
                <a href="#" style="color: white;">Data Umum</a>
            </li>
            <li class="separator" style="color: white;">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item" style="color: white;">
                <a href="#" style="color: white;">Daftar Tahun Pelajaran</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9);">
                <div class=" card-header">
                    <div class="card-title">
                        <a href="" class="btn btn-primary btn-sm text-white" data-toggle="modal"
                            data-target="#addTahunPelajaran"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>TAHUN PELAJARAN</th>
                                    <th>STATUS</th>
                                    <th>OPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                $ta = mysqli_query($koneksi,"SELECT * FROM ajaran");
                                foreach ($ta as $t) {?>
                                <tr>
                                    <td><?=$no++;?>.</td>
                                    <td><b><?=$t['tahun'];?></b></td>
                                    <td>
                                        <?php 
                                        if ($t['aktif'] == 0) {
                                            echo "<span class='badge badge-danger'>Tidak Aktif</span>";
                                        } else {
                                            echo "<span class='badge badge-success'>Aktif</span>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        if ($t['aktif'] == 0) { ?>
                                        <a onclick="return confirm('Yakin Ingin Mengaktifkan ??')"
                                            href="?page=data-umum&act=setta&id=<?=$t['id'] ?>&aktif=1"
                                            class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i>
                                            Aktifkan</a>
                                        <?php } else { ?>
                                        <a onclick="return confirm('Yakin Ingin Menonaktifkan ??')"
                                            href="?page=data-umum&act=setta&id=<?=$t['id'] ?>&aktif=0"
                                            class="btn btn-danger btn-sm"><i class="far fa-times-circle"></i>
                                            Nonaktif</a>
                                        <?php } ?>

                                        <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#edit<?=$t['id'] ?>"><i class="far fa-edit"></i> Edit</a>
                                        <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin Hapus Data ??')"
                                            href="?page=data-umum&act=delta&id=<?=$t['id'] ?>"><i
                                                class="fas fa-trash"></i>
                                            Del</a>

                                        <!-- Modal -->
                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                            tabindex="-1" id="edit<?=$t['id'] ?>" class="modal fade">
                                            <div class="modal-dialog modal-dialog" role="document">
                                                <div class="modal-content"
                                                    style="background-color: rgba(57, 57, 57, 1); color: white;">
                                                    <div class="modal-header">
                                                        <h4 id="exampleModalLabel" class="modal-title">Edit Tahun
                                                            Pelajaran</h4>
                                                        <button type="button" data-dismiss="modal" aria-label="Close"
                                                            class="close" style="color: white;"><span
                                                                aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label style="color: white !important;">Tahun
                                                                            Pelajaran</label>
                                                                        <input name="id" type="hidden"
                                                                            value="<?=$t['id'] ?>">
                                                                        <input name="tp" type="text"
                                                                            value="<?=$t['tahun']?>"
                                                                            class="form-control"
                                                                            style="background-color: rgba(57, 57, 57, 1); color: white; border-color: white;">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button name="edit"
                                                                            class="btn btn-primary btn-lg btn-block"
                                                                            type="submit">Edit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <?php 
                if (isset($_POST['edit'])) {
                    mysqli_query($koneksi, "UPDATE ajaran SET aktif='0'");
                    $save= mysqli_query($koneksi,"UPDATE ajaran SET tahun='$_POST[tp]', aktif='$_POST[aktif]' WHERE id='$_POST[id]' ");
                    if ($save) {
                        echo "<script>
                        alert('Data diubah !');
                        window.location='?page=data-umum&act=tahun-ajaran';
                        </script>";                        
                    }
                }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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

<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addTahunPelajaran"
    class="modal fade">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content" style="background-color: rgba(57, 57, 57, 1); color: white;">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title">Tambah Tahun</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close" style="color: white;"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label style="color: white !important;">TAHUN PELAJARAN</label>
                        <input name="tp" type="text" placeholder="2020/2021" class="form-control" required
                            style="background-color: rgba(57, 57, 57, 1); color: white; border-color: white;">
                    </div>
                    <div class="form-group">
                        <button name="save" class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
                    </div>
                </form>
                <?php 
                if (isset($_POST['save'])) {
                    $save = mysqli_query($koneksi,"INSERT INTO ajaran VALUES(NULL,'$_POST[tp]','0')");
                    if ($save) {
                        echo "<script>
                        alert('Data tersimpan !');
                        window.location='?page=data-umum&act=tahun-ajaran';
                        </script>";                        
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>