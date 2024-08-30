<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title" style="color: white;">Rekap Presensi <?php echo  $_GET['id_kelas'];?></h4>
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
                <a style="color: white;">Rekap Presensi</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9);">
                <div class="card-body">

                    <div class="">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                        <input class="form-control form-control-sm bg-dark text-light" onchange="handlermonth(event);"
                            value="<?=date('Y-m')?>" type="month" id="monthpicker" name="bulan"
                            placeholder="Pilih Bulan">
                    </div>

                    <div class="table-responsive">
                        <table id="basic-datatables" class="table table-hover table-dark" style="color: white;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Hadir</th>
                                    <th>Sakit</th>
                                    <th>Ijin</th>
                                    <th>Alpha</th>
                                    <th>Total Absen</th>
                                    <th>Jumlah Siswa</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="tbodyid">
                                <?php 
                        $no=1;
                        $rekap_kelas = rekap_by_kelas($id_login, $_GET['id_kelas'], date('Y-m'));
                        foreach ($rekap_kelas['data'] as $g) {?>
                                <tr>
                                    <td><?=$no++;?>.</td>
                                    <td><?=$g['tanggal_transaksi'];?></td>
                                    <td><?=$g['hadir'];?></td>
                                    <td><?=$g['sakit'];?></td>
                                    <td><?=$g['ijin'];?></td>
                                    <td><?=$g['alpha'];?></td>
                                    <td><?=$g['total_absen'];?></td>
                                    <td><?=$g['jumlah_siswa'];?></td>
                                    <td>
                                        <?php 
                                        if ($g['total_absen'] != $g['jumlah_siswa']){
                                            $edit = "";
                                            $cetak = "disabled";
                                            array_push($cetaksemua, 0);
                                        }else{
                                            $edit = "disabled-link";
                                            $cetak = " ";
                                            array_push($cetaksemua, 1);
                                        }
                                        ?>
                                        <a href="?page=presensi&id_kelas=<?php echo $_GET['id_kelas'];?>&tanggal=<?php echo $g['tanggal_transaksi'];?>"
                                            class="btn btn-success <?php echo $edit;?>">Edit</a>

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