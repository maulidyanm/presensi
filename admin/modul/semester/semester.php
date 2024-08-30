<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title" style="color: white;">Semester</h4>
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
                <a href="#" style="color: white;">Data Umum</a>
            </li>
            <li class="separator" style="color: white;">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item" style="color: white;">
                <a href="#" style="color: white;">Daftar Semester</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9);">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SEMESTER</th>
                                    <th>STATUS</th>
                                    <th>OPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                $semester = mysqli_query($koneksi,"SELECT * FROM semester");
                                foreach ($semester as $k) {?>
                                <tr>
                                    <td><?=$no++;?>.</td>
                                    <td><?=$k['status'];?></td>
                                    <td>
                                        <?php 
                                            if ($k['aktif'] == 0) {
                                                echo "<span class='badge badge-danger'>Tidak Aktif</span>";
                                            } else {
                                                echo "<span class='badge badge-success'>Aktif</span>";
                                            }
                                            ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if ($k['aktif'] == 0) {
                                                ?>
                                        <a onclick="return confirm('Yakin Aktifkan Semester  ??')"
                                            href="?page=data-umum&act=set_semester&id=<?=$k['id'] ?>&aktif=1"
                                            class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i>
                                            Aktifkan</a>
                                        <?php
                                            } else {
                                                ?>
                                        <a onclick="return confirm('Yakin NonAktifkan Semester  ??')"
                                            href="?page=data-umum&act=set_semester&id=<?=$k['id'] ?>&aktif=0"
                                            class="btn btn-danger btn-sm"><i class="far fa-times-circle"></i>
                                            Nonaktif</a>
                                        <?php
                                            }
                                            ?>

                                        <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#edit<?=$k['id'] ?>"><i class="far fa-edit"></i> Edit</a>

                                        <!-- Modal -->
                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                            tabindex="-1" id="edit<?=$k['id'] ?>" class="modal fade"
                                            style="display: none;">
                                            <div class="modal-dialog modal-dialog" role="document">
                                                <div class="modal-content"
                                                    style="background-color: rgba(57, 57, 57, 1); color: white;">
                                                    <div class="modal-header">
                                                        <h4 id="exampleModalLabel" class="modal-title">Edit semester
                                                        </h4>
                                                        <button type="button" data-dismiss="modal" aria-label="Close"
                                                            class="close" style="color: white;"><span
                                                                aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            style="color: white !important;">Semester</label>
                                                                        <input name="id" type="hidden"
                                                                            value="<?=$k['id'] ?>">
                                                                        <input name="semester" type="text"
                                                                            value="<?=$k['status']?>"
                                                                            class="form-control"
                                                                            style="background-color: rgba(57, 57, 57, 1); color: white; border-color: white;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 ">
                                                                    <div class="form-group">
                                                                        <button name="edit"
                                                                            class="btn btn-primary btn-lg" type="submit"
                                                                            style="width: 100%;">Edit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <?php 
                if (isset($_POST['edit'])) {
                    $save = mysqli_query($koneksi,"UPDATE semester SET status='$_POST[semester]' WHERE id='$_POST[id]' ");
                    if ($save) {
                        echo "<script>
                        alert('Data diubah !');
                        window.location='?page=data-umum&act=semester';
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