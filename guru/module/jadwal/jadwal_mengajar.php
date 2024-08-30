<style>
.btn-default {
    color: #000;
    /* Warna teks menjadi hitam */
    background-color: #fff;
    /* Warna latar belakang menjadi putih */
    border-color: #ccc;
    /* Warna border */
}

.page-title {
    color: #fff;
    /* Warna teks menjadi putih */
}

.flaticon-home {
    color: #fff;
    /* Warna teks menjadi putih */
}

.flaticon-right-arrow {
    color: #fff;
    /* Warna teks menjadi putih */
}

.jadwal {
    color: #fff;
    /* Warna teks menjadi putih */
}
</style>
<div class="page-inner">

    <div class="page-header">
        <h4 class="page-title">Jadwal</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="main.php">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">
                    <h5 class="jadwal">Jadwal Mengajar</h5>
                </a>
            </li>
        </ul>
    </div>
    <div class="input-group date">
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
        <input class="form-control form-control-sm bg-dark text-light" type="text" id="datepicker" name="tanggal"
            placeholder="Pilih Minggu Mengajar">
    </div>

    <div class="row mt-4">


        <div class="col-md-4 col-xs-12">

            <div class="alert alert-info alert-dismissible" role="alert" id="hari_1">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <strong>
                    Senin (<span id="sp_1"> - </span>)
                </strong>
                <hr id="st_1">
                <ul id="jd_1"></ul>

                <hr id="hr_1">

            </div>
        </div>
        <div class="col-md-4 col-xs-12">

            <div class="alert alert-info alert-dismissible" role="alert" id="hari_2">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <strong>
                    Selasa (<span id="sp_2"> - </span>)
                </strong>
                <hr id="st_2">
                <ul id="jd_2"></ul>

                <hr id="hr_2">

            </div>
        </div>
        <div class="col-md-4 col-xs-12">

            <div class="alert alert-info alert-dismissible" role="alert" id="hari_3">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <strong>
                    Rabu (<span id="sp_3"> - </span>)
                </strong>
                <hr id="st_3">
                <ul id="jd_3"></ul>

                <hr id="hr_3">

            </div>
        </div>
        <div class="col-md-4 col-xs-12">

            <div class="alert alert-info alert-dismissible" role="alert" id="hari_4">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <strong>
                    Kamis (<span id="sp_4"> - </span>)
                </strong>
                <hr id="st_4">
                <ul id="jd_4"></ul>

                <hr id="hr_4">

            </div>
        </div>
        <div class="col-md-4 col-xs-12">

            <div class="alert alert-info alert-dismissible" role="alert" id="hari_5">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <strong>
                    Jumat (<span id="sp_5"> - </span>)
                </strong>
                <hr id="st_5">
                <ul id="jd_5"></ul>

                <hr id="hr_5">

            </div>
        </div>

    </div>
    <a href="javascript:history.back()" class="btn btn-default"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
</div>