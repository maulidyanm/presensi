<?php 
$edit = mysqli_query($koneksi,"SELECT * FROM tbl_staff WHERE id_staff='$_GET[id]' ");
foreach ($edit as $d) { ?>
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
                <a href="#" style="color: white;">Edit Guru</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9);">
                <div class="card-header d-flex align-items-center">
                    <h3 class="h4" style="color: white !important;">Form Edit Guru</h3>
                </div>
                <div class="card-body">
                    <form action="?page=guru&act=proses" method="post" enctype="multipart/form-data">
                        <table cellpadding="3" style="font-weight: bold; width: 100%;">
                            <tr>
                                <td style="color: white !important; width: 30%;">ID Guru</td>
                                <td style="color: white; width: 5%;">:</td>
                                <td style="width: 65%;">
                                    <input name="id" type="text" class="form-control" value="<?=$d['id_staff'] ?>"
                                        readonly style="background-color: rgba(36, 36, 44, 0.9); color: black;">
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white !important;">Nama Guru</td>
                                <td style="color: white; width: 5%;">:</td>
                                <td>
                                    <input name="nama" type="text" class="form-control" value="<?=$d['nama'] ?>"
                                        required style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white !important;">Email</td>
                                <td style="color: white; width: 5%;">:</td>
                                <td>
                                    <input name="email" type="text" class="form-control" value="<?=$d['email'] ?>"
                                        required style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                                    <span class="text-danger"><em>Email digunakan untuk Password default</em></span>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white !important;">Foto</td>
                                <td style="color: white; width: 5%;">:</td>
                                <td>
                                    <input type="file" name="foto"
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">
                                    <button name="editGuru" type="submit" class="btn btn-primary"><i
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