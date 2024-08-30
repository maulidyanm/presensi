<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Aplikasi Presensi</h2>
                <h5 class="text-white op-7 mb-2">Selamat Datang, <b
                        class="text-warning"><?=$data['nama']; ?></b> | Aplikasi Presensi Siswa</h5>
            </div>
            <!-- <div class="ml-md-auto py-2 py-md-0">
								<a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
								<a href="#" class="btn btn-secondary btn-round">Add Customer</a>
							</div> -->
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row mt--2">
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">
                        <center>
                            <img src="../guru/logosmk.png" width="100">
                            <br>
                            <b>SMK N 6 SURAKARTA</b>
                        </center>
                    </div>
                    <div class="card-category">
                        <center>
                            Jl. Adi Sucipto No.38, Kerten, Kec. Laweyan, Kota Surakarta, Jawa Tengah 57143
                            <br>Email : admin@smkn6solo.sch.id Telp.(0271)726036
                        </center>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <!-- 	<div class="card-header">
									<h4 class="card-title">Nav Pills With Icon (Horizontal Tabs)</h4>
								</div> -->
                <div class="card-body">

                    <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-center"
                        id="pills-tab-with-icon" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="pills-home-tab-icon" data-toggle="pill" href="#pills-home-icon"
                                role="tab" aria-controls="pills-home-icon" aria-selected="true">
                                <i class="fas fa-clipboard-list"></i>
                                Absen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab-icon" data-toggle="pill"
                                href="#pills-profile-icon" role="tab" aria-controls="pills-profile-icon"
                                aria-selected="false">
                                <i class="fas fa-list-alt"></i>
                                Rekap
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab-icon" data-toggle="pill"
                                href="#pills-contact-icon" role="tab" aria-controls="pills-contact-icon"
                                aria-selected="false">
                                <i class="fas fa-user-astronaut"></i>
                                About
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                        <div class="tab-pane fade" id="pills-home-icon" role="tabpanel"
                            aria-labelledby="pills-home-tab-icon">
                            <p>
                            <ul class="list-group">
                                <?php


											foreach ($mengajar as $dm) { ?>
                                <li class="list-group-item">
                                    <a class="btn btn-primary btn-block text-left"
                                        href="?page=absen&pelajaran=<?=$dm['id_mengajar'] ?> ">
                                        <i class="fas fa-chevron-circle-right"></i>
                                        <span class="sub-item"><?=strtoupper($dm['mapel']); ?>
                                            (<?=strtoupper($dm['nama_kelas']); ?>)</span>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                            </p>

                        </div>
                        <div class="tab-pane fade" id="pills-profile-icon" role="tabpanel"
                            aria-labelledby="pills-profile-tab-icon">

                            <p>
                            <ul class="list-group">
                                <?php


										foreach ($mengajar as $dm) { ?>
                                <li class="list-group-item">
                                    <a class="btn btn-secondary btn-block text-left"
                                        href="?page=rekap&pelajaran=<?=$dm['id_mengajar'] ?> ">
                                        <i class="fas fa-chevron-circle-right"></i>
                                        <span class="sub-item"><?=strtoupper($dm['mapel']); ?>
                                            (<?=strtoupper($dm['nama_kelas']); ?>)</span>
                                    </a>
                                    <?php 
										$bulan = date('m');

										?>
                                </li>
                                <?php } ?>
                            </ul>
                            </p>


                        </div>
                        <div class="tab-pane fade" id="pills-contact-icon" role="tabpanel"
                            aria-labelledby="pills-contact-tab-icon">
                            <p>
                                <hr>

                                Aplikasi Presensi siswa ini dibuat untuk mendokumentasikan kehadiran siswa, Aplikasi
                                ini dibuat oleh Kelompok 4
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">


</div>

</div>
<!--watermark-->
<footer class="footer dark-footer">
    <div class="container">
        <div class="copyright ml-auto">
            &copy; <?php echo date('Y');?> SMK N 6 SURAKARTA (<a href="main.php">Kelompok 4 </a> |
            2024)
        </div>
    </div>
</footer>