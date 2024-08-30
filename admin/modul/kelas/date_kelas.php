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

.copyright {
    margin-left: 30px;
}
</style>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Kelas</h4>
        <ul class="breadcrumbs" color="white ">
            <li class="nav-home">
                <a href="main.php">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a href="#">Data Umum</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a href="#">Daftar Kelas</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="" class="btn btn-primary btn-sm text-white" data-toggle="modal"
                            data-target="#addKelas"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">KODE KELAS</th>
                                    <th scope="col">NAMA KELAS</th>
                                    <th scope="col">OPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                        $no=1;
                        $kelas = mysqli_query($koneksi,"SELECT * FROM kelas");
                        foreach ($kelas as $k) {?>
                                <tr>
                                    <td><b><?=$no++;?>.</b></td>
                                    <td><?=$k['code'];?></td>
                                    <td><?=$k['kelas'];?></td>
                                    <td>

                                        <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#edit<?=$k['id_kelas'] ?>"><i class="far fa-edit"></i> Edit</a>
                                        <a class="btn btn-danger btn-sm" onclick="return confirm('Yakin Hapus Data ??')"
                                            href="?page=data-umum&act=delkelas&id=<?=$k['id_kelas'] ?>"><i
                                                class="fas fa-trash"></i> Delete</a>
                                        <!-- Modal -->
                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                            tabindex="-1" id="edit<?=$k['id_kelas'] ?>" class="modal fade"
                                            style="display: none;">
                                            <div class="modal-dialog" style="max-width: 400px;">
                                                <div class="modal-content"
                                                    style="background-color: rgba(57, 57, 57, 1); color: white;">
                                                    <div class="modal-header">
                                                        <h4 id="exampleModalLabel" class="modal-title">Edit Kelas</h4>
                                                        <button type="button" data-dismiss="modal" aria-label="Close"
                                                            class="close" style="color: white;"><span
                                                                aria-hidden="true">×</span></button>

                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label style="color: white !important;">Nama
                                                                            Kelas</label>
                                                                        <input name="id" type="hidden"
                                                                            value="<?=$k['id_kelas'] ?>">
                                                                        <input name="kelas" type="text"
                                                                            value="<?=$k['kelas']?>"
                                                                            class="form-control"
                                                                            style="background-color: rgba(57, 57, 57, 1); color: white; border-color: white;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button name="edit"
                                                                            class="btn btn-primary btn-block btn-sm"
                                                                            type="submit">Edit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <?php 
                                                        if (isset($_POST['edit'])) {
                                                            $save= mysqli_query($koneksi,"UPDATE kelas SET kelas='$_POST[kelas]' WHERE id_kelas='$_POST[id]' ");
                                                            if ($save) {
                                                                echo "<script>
                                                                alert('Data diubah !');
                                                                window.location='?page=data-umum&act=kelas';
                                                                </script>";                        
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <!-- Modal "Tambah Kelas" -->
            <div id="addKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                class="modal fade text-left">
                <div role="document" class="modal-dialog modal-lg">
                    <div class="modal-content" style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                        <div class="modal-header">
                            <h4 id="exampleModalLabel" class="modal-title">Tambah Kelas</h4>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <?php
                        // Ambil kode kelas terakhir dari database
                        $query_last_code = "SELECT code FROM kelas ORDER BY id_kelas DESC LIMIT 1";
                        $result_last_code = mysqli_query($koneksi, $query_last_code);
                        if ($row_last_code = mysqli_fetch_assoc($result_last_code)) {
                            $last_code = $row_last_code['code'];

                            // Ekstrak nomor urut dari kode kelas terakhir
                            preg_match('/(\d+)$/', $last_code, $matches);
                            $last_number = intval($matches[0]);

                            // Tambahkan 1 ke nomor urut
                            $next_number = $last_number + 1;

                            // Format ulang kode kelas berikutnya
                            $next_code = preg_replace('/\d+$/', sprintf("%02d", $next_number), $last_code);
                        } else {
                            // Jika tidak ada kode kelas sebelumnya, set default
                            $next_code = "KXI 01";
                        }
                        ?>
                                    <label style="color: white !important;">Kode Kelas</label>
                                    <input name="kode" type="text" value="<?php echo $next_code; ?>"
                                        class="form-control"
                                        style="background-color: rgba(36, 36, 44, 0.9); color: black;" readonly>
                                    <div class=" form-group">
                                        <label style="color: white !important;">Nama Kelas</label>
                                        <input name="kelas" type="text" placeholder="Nama kelas .." class="form-control"
                                            style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                                    </div>

                                    <div class="form-group">
                                        <button name="save" class="btn btn-primary" type="submit">Simpan</button>
                                        <button type="button" data-dismiss="modal"
                                            class="btn btn-secondary">Batal</button>
                                    </div>
                            </form>
                            <?php 
        if (isset($_POST['save'])) {
           
            $save= mysqli_query($koneksi,"INSERT INTO kelas VALUES(NULL,'$_POST[kode]','$_POST[kelas]') ");
            if ($save) {
                echo "<script>
                alert('Data tersimpan !');
                window.location='?page=data-umum&act=kelas';
                </script>";                        
            }
        }

         ?>


                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->


        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>