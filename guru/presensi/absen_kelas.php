<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title" style="color: white;">Presensi</h4>
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
                <a style="color: white;">Absen Siswa</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a style="color: white;"><?php echo  $_GET['id_kelas'];?></a>
            </li>
            </<li class="separator">
            <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a style="color: white;"><?php htmlspecialchars($x['pelajaran']); ?></a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9);">
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="basic-datatables" class="table table-hover table-dark" style="color: white;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th>Opsi</th>
                                    <th>Keterangan</th>
                                    <th>Simpan</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                        $no=1;
                        $siswa = siswa($_GET['id_kelas']);

                        
                        foreach ($siswa['data'] as $s) {
                            $get_siswa = get_absen($id_login, $s['id_siswa'], $_GET['tanggal']);
                            ?>

                                <form method='POST'>
                                    <tr>
                                        <td><?=$no++;?>.</td>
                                        <td><?=$s['nis'];?></td>
                                        <td><?=$s['nama'];?></td>
                                        <td style="white-space: nowrap"><?=$s['kelas'];?></td>

                                        <td><?php if ($s['status']=='Y') {
                                echo "<span class='badge badge-success'>Aktif</span>";
                                
                            }else {
                                echo "<span class='badge badge-danger'>Off</span>";
                            } ?></td>

                                        <td>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-check">

                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="ket-h-<?=$i;?>" value="H" required
                                                            <?php if (!empty($get_siswa['data']['status']) && $get_siswa['data']['status'] == 'H') echo 'checked'; ?>>

                                                        <label class="form-check-label text-white"
                                                            for="ket-h-<?=$i;?>">H</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="ket-i-<?=$i;?>" value="I" required
                                                            <?php if (!empty($get_siswa['data']['status']) && $get_siswa['data']['status'] == 'I') echo 'checked'; ?>>
                                                        <label class="form-check-label text-white"
                                                            for="ket-i-<?=$i;?>">I</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="ket-s-<?=$i;?>" value="S" required
                                                            <?php if (!empty($get_siswa['data']['status']) && $get_siswa['data']['status'] == 'S') echo 'checked'; ?>>
                                                        <label class="form-check-label text-white"
                                                            for="ket-s-<?=$i;?>">S</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="ket-a-<?=$i;?>" value="A" required
                                                            <?php if (!empty($get_siswa['data']['status']) && $get_siswa['data']['status'] == 'A') echo 'checked'; ?>>
                                                        <label class="form-check-label text-white"
                                                            for="ket-a-<?=$i;?>">A</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                        if(!empty($get_siswa['data']['keterangan'])){
                                            $keterangan = $get_siswa['data']['keterangan'];
                                        }else {
                                            $keterangan = '';
                                        }
                                        ?>
                                            <input class="form-control form-control-sm bg-dark text-light" type="text"
                                                placeholder="" aria-label="form-control-sm example" name="keterangan"
                                                value="<?php echo $keterangan;?>">
                                        </td>
                                        <td>
                                            <input type="hidden" name="id_siswa" , value="<?php echo $s['id_siswa'];?>">
                                            <input type="hidden" name="tanggal" ,
                                                value="<?php echo $_GET['tanggal'];?>">
                                            <input type="hidden" name="id_staff" , value="<?php echo $id_login;?>">
                                            <button type="submit" name='act' value="simpan"
                                                class="btn btn-primary">Simpan</button>
                                        </td>
                                    </tr>
                                </form>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>