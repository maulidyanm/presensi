<div class="panel-header" style="background-color: #011c40 !important;">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Aplikasi Presensi</h2>
                <h5 class="text-white op-7 mb-2">Selamat Datang, <b
                        class="text-warning"><?=$data['nama_lengkap']; ?></b> | Aplikasi Presensi Siswa</h5>
            </div>
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
                    <div class="card-category" style="font-weight: bold !important;">
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

                    <div class="row">

                        <div class="col-sm-6 col-md-6">
                            <div class="card card-stats card-secondary card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="flaticon-users"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-stats">
                                            <div class="numbers">
                                                <p class="card-category">Total Siswa</p>
                                                <h4 class="card-title"><?php echo $jumlahsiswa; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="card card-stats card-default card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-stats">
                                            <div class="numbers">
                                                <p class="card-category">Total Guru</p>
                                                <h4 class="card-title"><?php echo $jumlahGuru; ?></h4>
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
    </div>
</div>