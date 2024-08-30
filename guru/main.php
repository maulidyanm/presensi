<?php
session_start();
include 'fungsi.php';

if (!isset($_SESSION['id_staff'])) {
?>
<script>
alert('Maaf ! Anda Belum Login !!');
window.location = '../login.php';
</script>
<?php
}


$id_login = @$_SESSION['id_staff'];
$get_data = get_data_guru($id_login);
$data = $get_data['data'][0];
$cetaksemua = array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Guru | Presensi</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link href="asset/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="asset/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <meta charset="UTF-8">
    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/atlantis.min.css">
    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ['assets/css/fonts.min.css']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logosmk.png">
    <style>
    body {
        background-image: url('main-bg.jpg');
        background-size: cover;
        background-position: center;

    }

    .disabled-link {
        pointer-events: none;
        cursor: not-allowed;
        opacity: 0.5;
    }

    .navbar-custom {
        background-color: #343a40;
        /* Warna latar belakang navbar */
    }

    .scrollbar-inner {
        scrollbar-width: thin;
        scrollbar-color: rgba(109, 109, 109, 1) rgba(8, 8, 32, 0.8);
        /* Warna handle dan latar belakang track */
    }

    .scrollbar-inner::-webkit-scrollbar {
        width: 0.1px;
    }

    .dark-footer {
        background-color: #1A2035;
        /* Warna latar belakang gelap */
        color: #fff;
    }

    .ui-datepicker tr:hover {
        background-color: #808080;
    }

    input[type="month"]::-ms-clear {
        display: none;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">

                <a href="main.php" class="logo">
                    <img src="logo.png" alt="navbar brand" class="navbar-brand" width="40">
                    <b class="text-white">Presensi Siswa</b>
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark">

                <div class="container-fluid">

                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item toggle-nav-search hidden-caret">
                            <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button"
                                aria-expanded="false" aria-controls="search-nav">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>



                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="assets/img/user/<?=$data['profil'] ?>" alt="..."
                                        class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg"><img src="assets/img/user/<?=$data['profil'] ?>"
                                                    alt="image profile" class="avatar-img rounded"></div>
                                            <div class="u-text">
                                                <h4><?=$data['nama'] ?></h4>
                                                <p class="text-muted"><?=$data['email'] ?></p>

                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#gantiPassword" class="collapsed">Ganti Password</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#pengaturanAkun" class="collapsed">Account Setting</a>

                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2" data-background-color="dark2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="assets/img/user/<?=$data['profil'] ?>" alt="..."
                                class="avatar-img rounded-circle">

                        </div>
                        <div class="info">
                            <span>
                                <?=$data['nama'] ?>
                                <span class="user-level"><br><?=$data['tipe'] ?></span>
                                <span class="caret"></span>
                            </span>
                            <div class="clearfix"></div>


                        </div>
                    </div>
                    <ul class="nav nav-primary">
                        <li class="nav-item active">
                            <a href="main.php" class="collapsed">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Main Utama</h4>
                        </li>

                        <li class="nav-item">
                            <a href="?page=jadwal">
                                <i class="fas fa-clipboard-check"></i>
                                <p>Jadwal Mengajar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#sidebarLayouts">
                                <i class="fas fa-list-alt"></i>
                                <p>Presensi</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="sidebarLayouts">
                                <ul class="nav nav-collapse">
                                    <?php 
									
								
                                    //kelas berdasarkan id staff
                                    $get_kelas = get_kelas_presensi($id_login);
                                    
									foreach ($get_kelas['data'] as $x) {
                                                                         
									
											?>
                                    <li>
                                        <a href="?page=presensi&id_kelas=<?= htmlspecialchars($x['kelas']) ?>">
                                            <span class="sub-item">
                                                <?= strtoupper(htmlspecialchars($x['kelas'])); ?>
                                            </span>
                                        </a>
                                    </li>

                                    <?php
                                         }
                                    ?>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#rekapAbsen">
                                <i class="fas fa-list-alt"></i>
                                <p>Rekap Absen</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="rekapAbsen">
                                <ul class="nav nav-collapse">
                                    <?php 
									
								
                                    //kelas berdasarkan id staff
                                    $get_kelas = get_kelas_rekap($id_login);
                                    
									foreach ($get_kelas['data'] as $x) {
                                                                         
									
											?>
                                    <li>
                                        <a href="?page=rekap&id_kelas=<?= htmlspecialchars($x['kelas']); ?>">
                                            <span class="sub-item">
                                                <?= strtoupper(htmlspecialchars($x['kelas'])) . " (" . htmlspecialchars($x['pelajaran']) . ")"; ?>
                                            </span>
                                        </a>

                                    </li>

                                    <?php
                                         }
                                    ?>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item active mt-3">
                            <a href="#" class="collapsed" onclick="confirmLogout()">
                                <i class="fas fa-arrow-alt-circle-left"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- modal ganti password -->
        <div class="modal fade bs-example-modal-sm" id="gantiPassword" tabindex="-1" role="dialog"
            aria-labelledby="gantiPass">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="gantiPass">Ganti Password</h4>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label">Password Lama</label>
                                <input name="pass" type="password" id="pass" class="form-control"
                                    placeholder="Password Lama">
                                <input type="checkbox" class="form-check-input" onclick="myFunction('pass')">Show
                                Password
                            </div>
                            <div class="form-group">
                                <label class="control-label">Password Baru</label>
                                <input name="pass1" type="password" id="pass1" class="form-control"
                                    placeholder="Password Baru">
                                <input type="checkbox" class="form-check-input" onclick="myFunction('pass1')">Show
                                Password
                            </div>
                            <div class="form-group">
                                <label class="control-label">Konfirmasi Password Baru</label>
                                <input name="pass2" type="password" id="pass2" class="form-control"
                                    placeholder="Konfirmasi Password Baru">
                                <input type="checkbox" class="form-check-input" onclick="myFunction('pass2')">Show
                                Password
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button name="changePassword" type="submit" class="btn btn-primary">Ganti Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal pengaturan akun-->
        <div class="modal fade" id="pengaturanAkun" tabindex="-1" role="dialog" aria-labelledby="akunAtur">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="akunAtur"><i class="fas fa-user-cog"></i> Pengaturan Akun</h3>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="<?=$data['nama'] ?>"
                                    disabled>
                                <input type="hidden" name="id" value="<?=$data['id_staff'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="username" class="form-control" value="<?=$data['email'] ?>"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label>Foto Profile</label>
                                <p>
                                    <img src="assets/img/user/<?=$data['profil'] ?>" class="img-thumbnail"
                                        style="height: 50px;width: 50px;">
                                </p>
                                <input type="file" name="foto">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button name="updateProfile" type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="main-panel">
            <div class="content">

                <!-- Halaman dinamis -->
                <?php 
				error_reporting();
				$page= @$_GET['page'];
				$act = @$_GET['act'];
				$tipe_rekap = @$_GET['type'];
                if (isset($_POST['updateProfile'])) {
                    $upload = upload_profil($id_login, $_FILES);
                    $pesan = $upload['msg'];
                    clearstatcache();
                    header("Cache-Control: no-cache, must-revalidate");
                    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                    header("Content-Type: application/xml; charset=utf-8");
                    header("Location: main.php");
                }

                if (isset($_POST['changePassword'])) {
                    $password_baru = update_password($id_login, $_POST);
                    $pesan = $password_baru['msg'];
                    ?>
                <script>
                alert('<?php echo $pesan; ?>');
                </script>
                <?php
                }

				if ($page=='jadwal') {
					if ($act=='') {
						include 'module/jadwal/jadwal_mengajar.php';
					}
                }elseif ($page=='presensi') {
                    if (isset($_POST['act'])) {
                        $upsert = upsert_absen($_POST);
                    ?>
                <script>
                alert('<?php echo $upsert['msg']; ?>');
                </script>
                <?php
                    }
                    include 'presensi/absen_kelas.php';
					
                    
				}elseif ($page=='rekap') {
					if ($tipe_rekap=='harian') {
						include 'rekap/rekap_by_tanggal.php';
					} else {
                        include 'rekap/rekap_by_kelas.php';
                    }
                }elseif ($page=='') {
					include 'module/home.php';
                }elseif ($page=='akun') {
                        include 'module/akun/akun.php';
				}else{
					echo "<b>Tidak ada Halaman</b>";
				}
				?>

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
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>



    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Atlantis JS -->
    <script src="assets/js/atlantis.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

    <script>
    function confirmLogout() {
        var isConfirmed = confirm("Apakah Anda yakin ingin logout?");

        if (isConfirmed) {
            // Redirect atau jalankan proses logout di sini
            window.location.href = "../login.php?logout";
        }
    }
    </script>



</body>
<script>
// password
function myFunction($id) {
    var x = document.getElementById($id);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
// password

const allEqual = arr => arr.every(val => val === arr[0]);
/* JS untuk halaman jadwal_mengajar.php */
function clear() {
    for (let i = 1; i < 6; i++) {
        document.getElementById("jd_" + i).innerHTML = "";
        document.getElementById("sp_" + i).innerHTML = " - ";
    }
}

function cetak(item, index) {

    var jadwal = document.getElementById("jd_" + item.hari_mengajar);
    var pelajaran = document.getElementById("sp_" + item.hari_mengajar);
    pelajaran.innerHTML = " " + item.pelajaran + " ";
    var li = document.createElement("li");
    li.appendChild(document.createTextNode(item.mulai_mengajar + " - " + item.akhir_mengajar + " (" + item.kelas +
        ")"));
    jadwal.appendChild(li);

}

function get_data(id_staff, tanggal_mulai) {
    const xhr = new XMLHttpRequest();
    var base_url = window.location.origin;
    xhr.open("POST", base_url + "/fungsi.php");
    xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");

    const body = JSON.stringify({
        id_staff: id_staff,
        tanggal_mulai: tanggal_mulai,
        action: 'jadwal'
    });
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var datajson = JSON.parse(xhr.responseText)
            var datum = datajson.data;
            clear();
            datum.forEach(cetak);
        } else {
            /* console.log(`Error: ${xhr.status}`); */
            alert(`Error: ${xhr.status}`);
        }
    };
    xhr.send(body);
}

$(function() {
    $("#datepicker").datepicker({
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [(day != 0 && day != 6), ''];
        },
        dateFormat: 'yy-mm-dd', // Format tanggal (YYYY-MM-DD)
        onSelect: function(tanggal) {
            var date = new Date(tanggal);
            var newFirstDate = new Date(tanggal);
            var newLastDate = new Date(tanggal);
            var day = date.getDay();

            var firstDay = 1;
            var lastDay = 5;
            var toFirstDay = day - firstDay;
            var toLastDay = lastDay - day;
            newFirstDate.setDate(date.getDate() - toFirstDay);
            newLastDate.setDate(date.getDate() + toLastDay);
            // Mengganti nilai input teks datepicker saat memilih tanggal
            $("#datepicker").val(newFirstDate.toISOString().slice(0, 10) + " sampai " + newLastDate
                .toISOString().slice(0, 10));

            get_data('<?php echo $id_login;?>', newFirstDate.toISOString().slice(0, 10));
        }
    });
});
/* JS untuk halaman jadwal_mengajar.php */
/* JS untuk halaman rekap_by_kelas (cetak) */
function download(id_staff, id_kelas, tanggal) {
    var request = new XMLHttpRequest();
    var base_url = window.location.origin;
    request.open('POST', base_url + "/fungsi.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    request.responseType = 'blob';
    const body = JSON.stringify({
        id_staff: id_staff,
        id_kelas: id_kelas,
        tanggal: tanggal,
        action: 'download'
    });
    request.onload = function() {
        // Only handle status code 200
        if (request.status === 200) {
            // Try to find out the filename from the content disposition `filename` value
            var disposition = request.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);
            var filename = (matches != null && matches[1] ? matches[1] : 'file.pdf');

            // The actual download
            var blob = new Blob([request.response], {
                type: 'application/pdf'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();

            document.body.removeChild(link);
        }

        // some error handling should be done here...
    };

    request.send(body);
};
/* JS untuk halaman rekap_by_kelas (cetak) */

// JS monthpicker
function cetakbulan(item, index) {

    var jadwal = document.getElementById("tbodyid");
    var tr = document.createElement("tr");
    var td1 = document.createElement("td");
    var td2 = document.createElement("td");
    var td3 = document.createElement("td");
    var td4 = document.createElement("td");
    var td5 = document.createElement("td");
    var td6 = document.createElement("td");
    var td7 = document.createElement("td");
    var td8 = document.createElement("td");
    var td9 = document.createElement("td");
    var no = index + 1;
    console.log(jadwal);
    td1.innerHTML = no + ".";
    td2.innerHTML = item.tanggal_transaksi;
    td3.innerHTML = item.hadir;
    td4.innerHTML = item.sakit;
    td5.innerHTML = item.ijin;
    td6.innerHTML = item.alpha;
    td7.innerHTML = item.total_absen;
    td8.innerHTML = item.jumlah_siswa;
    if (item.jumlah_siswa != item.total_absen) {
        var editclass = "";
        var cetakclass = "disabled";
        cetaksemua.push(1);
    } else {
        var editclass = "disabled-link";
        var cetakclass = " ";
        cetaksemua.push(0);
    }
    var edit = "<a href=\"?page=presensi&id_kelas=" + item.kelas + "&tanggal=" + item.tanggal_transaksi +
        "\" class=\"btn btn-success " + editclass + "\" >Edit</a>";
    var cetak = "<button type=\"button\" class=\"btn btn-primary\" onclick=\"download('" + item.id_staff + "','" + item
        .kelas + "', '" + item.tanggal_transaksi + "')\" " + cetakclass + ">Cetak</button>"
    td9.innerHTML = edit + " " + cetak;
    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td4);
    tr.appendChild(td5);
    tr.appendChild(td6);
    tr.appendChild(td7);
    tr.appendChild(td8);
    tr.appendChild(td9);
    jadwal.appendChild(tr);


}
var cetaksemua = [];

function get_data_bulan(id_staff, id_kelas, bulan) {
    const xhr = new XMLHttpRequest();
    var base_url = window.location.origin;

    xhr.open("POST", base_url + "/fungsi.php");
    xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");

    const body = JSON.stringify({
        id_staff: id_staff,
        id_kelas: id_kelas,
        bulan: bulan,
        action: 'jadwalbulan'
    });
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var datajson = JSON.parse(xhr.responseText)
            var datum = datajson.data;
            datum.forEach(cetakbulan);
            if (cetaksemua.length != 0) {
                console.log(1);
                if (allEqual(cetaksemua)) {
                    console.log(2);
                    document.getElementById('downloadall').disabled = false;
                } else {
                    console.log(3);
                    document.getElementById('downloadall').disabled = true;
                }
            } else {
                console.log(4);
                document.getElementById('downloadall').disabled = true;
            }
            cetaksemua = [];

        } else {
            /* console.log(`Error: ${xhr.status}`); */
            alert(`Error: ${xhr.status}`);
        }
    };
    xhr.send(body);
}

function handlermonth(e) {
    $("#tbodyid").empty();
    if (e.target.value != "") {
        get_data_bulan('<?php echo $id_login;?>', '<?php echo $_GET['id_kelas'];?>', e.target.value);
    } else {
        alert('Tanggal tidak boleh kosong');
    }
}

// JS monthpicker
</script>

</html>