<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['admin'])) {
?>
<script>
alert('Maaf ! Anda Belum Login !!');
window.location = '../login.php';
</script>
<?php
}

$jumlahGuru = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbl_staff WHERE status='Y' "));
$jumlahsiswa = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbl_siswa WHERE status='Y'"));

$id_login = @$_SESSION['admin'];

$sql = mysqli_query($koneksi,"SELECT * FROM administrator WHERE usernames = '$id_login'") or die(mysqli_error($koneksi));
$data = mysqli_fetch_array($sql);

// change password
if (isset($_POST['changePassword'])) {
    // Pastikan kedua bidang password diisi
    if (empty($_POST['passlama']) || empty($_POST['passbaru'])) {
        echo "<script type='text/javascript'>
              alert('Mohon isi kedua bidang password.');
              window.location.replace('main.php'); 
              </script>";
        exit;
    }

    // Ambil password lama dari database
    $passLama = $data['password']; // Password lama dalam bentuk hash
    $passInputLama = $_POST['passlama'];
    $newPassInput = $_POST['passbaru'];

    // Verifikasi password lama
    if (password_verify($passInputLama, $passLama)) {
        // Hash password baru sebelum menyimpannya
        $hashedNewPassword = password_hash($newPassInput, PASSWORD_DEFAULT);

        // Perbarui password di database dengan password baru yang di-hash
        $updateQuery = mysqli_query($koneksi, "UPDATE administrator SET password='$hashedNewPassword' WHERE id_akun='$data[id_akun]' ");

        if ($updateQuery) {
            echo "<script type='text/javascript'>
                  alert('Password Telah berubah');
                  window.location.replace('main.php'); 
                  </script>";
        } else {
            // Tangani pesan kesalahan dari MySQL
            echo "<script type='text/javascript'>
                  alert('Gagal mengubah password: " . mysqli_error($koneksi) . "');
                  window.location.replace('main.php'); 
                  </script>";
        }
    } else {
        echo "<script type='text/javascript'>
              alert('Password Lama Tidak cocok');
              window.location.replace('main.php'); 
              </script>";
    }
}


// ganti pengaturan akun
if (isset($_POST['updateProfile'])) {
    // Periksa apakah gambar dipilih
    if (!empty($_FILES['foto']['name'])) {
        $gambar = $_FILES['foto']['name'];
        // Pastikan path untuk menyimpan foto benar
        move_uploaded_file($_FILES['foto']['tmp_name'], "../admin/photo-profiles/$gambar");
        // Perbarui nama file gambar di database
        $updateFoto = mysqli_query($koneksi, "UPDATE administrator SET profiles='$gambar' WHERE id_akun='$data[id_akun]' ");
        if (!$updateFoto) {
            echo "<script>
                alert('Error updating photo: " . mysqli_error($koneksi) . "');
                window.location='main.php';
                </script>";
            exit;
        }
    }

    // Perbarui nama lengkap dan username
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    // Pastikan nilai $_POST['id'], $_POST['nama'], dan $_POST['username'] memiliki nilai yang benar
    $sqlEdit = mysqli_query($koneksi, "UPDATE administrator SET nama_lengkap='$nama', usernames='$username' WHERE id_akun='$data[id_akun]' ");
    if ($sqlEdit) {
        echo "<script>
            alert('Sukses ! Data berhasil diperbarui');
            window.location='main.php';
            </script>";
    } else {
        // Tampilkan pesan kesalahan jika ada
        echo "<script>
            alert('Error updating profile: " . mysqli_error($koneksi) . "');
            window.location='main.php';
            </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Administrator | Presensi</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta charset="UTF-8">
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
    <script src="../admin/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ['../assets/css/fonts.min.css']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <style>
    body {
        background-image: url('../admin/asset/background/main-bg.jpg');
        background-size: cover;
        background-position: center;
        overflow-x: hidden;
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

    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    .flipped {
        transform: scaleY(-1);
    }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">

                <a href="main.php" class=" logo">
                    <img src="logo.png" alt="navbar brand" class="navbar-brand" width="40">
                    <b class="text-white">Administrator</b>
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
                    <div class="collapse" id="search-nav">
                        <form class="navbar-left navbar-form nav-search mr-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pr-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input id="sidebar-search" type="text" placeholder="Search ..." class="form-control">
                            </div>
                        </form>
                    </div>
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
                                    <img src="../admin/photo-profiles/<?=$data['profiles'] ?>" alt=" ..."
                                        class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn"
                                style="background-color: rgba(57, 57, 57, 1); color: white;">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg"><img
                                                    src="../admin/photo-profiles/<?=$data['profiles'] ?>"
                                                    alt="image profile" class="avatar-img rounded">
                                            </div>
                                            <div class="u-text">
                                                <h4 style="color: white;"><?=$data['nama_guru'] ?></h4>
                                                <p class="text-muted" style="color: white;"><?=$data['email'] ?></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#gantiPassword" style="color: white;">Ganti Password</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#pengaturanAkun" style="color: white;">Account Setting</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="logout()"
                                            style="color: white;">Logout</a>
                                        <script>
                                        function logout() {
                                            if (confirm("Apakah Anda yakin ingin logout?")) {
                                                // Jika pengguna menekan OK, maka redirect ke halaman logout.php
                                                window.location.href = 'logout.php';
                                            } else {
                                                exit();
                                            }
                                        }
                                        </script>

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
                            <img src="../admin/photo-profiles/<?=$data['profiles'] ?>" alt="..."
                                class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    <?=$data['nama_lengkap'] ?>
                                    <span class="user-level">Administrator</span>
                                    <span class="caret"></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                            <div class="collapse in" id="collapseExample">
                                <ul class="nav">

                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#pengaturanAkun" class="collapsed">
                                            <span class="link-collapse">Pengaturan Akun</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#gantiPassword" class="collapsed">
                                            <span class="link-collapse">Ganti Password</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
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
                            <a data-toggle="collapse" href="#base">
                                <i class="fas fa-folder-open"></i>
                                <p>Data Umum</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="base">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="?page=data-umum&act=kelas">
                                            <span class="sub-item">Kelas</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="?page=data-umum&act=semester">
                                            <span class="sub-item">Semester</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="?page=data-umum&act=tahun-ajaran">
                                            <span class="sub-item">Tahun Pelajaran</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=data-umum&act=mapel">
                                            <span class="sub-item">Mata Pelajaran</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#sidebarLayouts">
                                <i class="fas fa-clipboard-list"></i>
                                <p>Jadwal Mengajar</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="sidebarLayouts">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="?page=jadwal&act=add ">
                                            <span class="sub-item">Tambah Jadwal</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=jadwal">
                                            <span class="sub-item">Daftar Mengajar</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>



                        <li class="nav-item">
                            <a data-toggle="collapse" href="#guru">
                                <i class="fas fa-user-tie"></i>
                                <p>Data Guru</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="guru">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="?page=guru&act=add ">
                                            <span class="sub-item">Tambah Guru</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=guru">
                                            <span class="sub-item">Daftar Guru</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a data-toggle="collapse" href="#siswa">
                                <i class="fas fa-user-friends"></i>
                                <p>Data Siswa</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="siswa">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="?page=siswa&act=add ">
                                            <span class="sub-item">Tambah Siswa</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=siswa">
                                            <span class="sub-item">Daftar Siswa</span>
                                        </a>
                                    </li>
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
									// Assuming $koneksi is your database connection variable

									// Perform the query
									$kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY id_kelas ASC");

									// Check if the query was successful
									if ($kelas) {
										// Fetch associative array
										while ($k = mysqli_fetch_assoc($kelas)) {
											?>
                                    <li>
                                        <a href="?page=rekap&id_kelas=<?= htmlspecialchars($k['kelas']) ?>">
                                            <span class="sub-item">
                                                <?= strtoupper(htmlspecialchars($k['kelas'])); ?></span>
                                        </a>
                                    </li>
                                    <?php
										}
										// Free result set
										mysqli_free_result($kelas);
									} else {
										// Query failed
										echo "Error: " . mysqli_error($koneksi);
									}
									?>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item active mt-3">
                            <a class=" collapsed" onclick="logout()">
                                <i class=" fas fa-arrow-alt-circle-left"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <script>
            // Function to handle search
            function searchSidebar() {
                // Get input value
                var input = document.getElementById("sidebar-search").value.toLowerCase();
                // Get all sidebar menu items
                var items = document.querySelectorAll(".nav.nav-primary .nav-item");
                // Loop through each item
                items.forEach(function(item) {
                    // Get the text content of the item
                    var text = item.textContent.toLowerCase();
                    // Check if the input is found in the text content
                    if (text.includes(input)) {
                        // Show the item if found
                        item.style.opacity = "1";
                        item.style.transform = "translateX(0)";
                        item.classList.remove("disabled");
                        // Check if the item has a collapse element
                        var collapse = item.querySelector(".collapse");
                        if (collapse) {
                            // Expand the collapse element
                            collapse.classList.add("show");
                        }
                        // Highlight the searched item
                        item.classList.add("active");
                    } else {
                        // Check if it's Dashboard or Logout item
                        var dashboardLogout = item.querySelector("p").textContent.toLowerCase();
                        if (dashboardLogout === "dashboard" || dashboardLogout === "logout") {
                            return; // Skip further processing for Dashboard and Logout items
                        }
                        // Disable the item if not found
                        item.style.opacity = "0.5";
                        item.style.transform = "translateX(-20px)";
                        item.classList.add("disabled");
                        // Check if the item has a collapse element
                        var collapse = item.querySelector(".collapse");
                        if (collapse) {
                            // Collapse the collapse element
                            collapse.classList.remove("show");
                            // Remove highlight from the item
                            item.classList.remove("active");
                        }
                    }
                });

                // If search input is empty, remove highlighting from all items and collapse all opened menus
                if (input === "") {
                    items.forEach(function(item) {
                        var dashboardLogout = item.querySelector("p").textContent.toLowerCase();
                        if (dashboardLogout === "dashboard" || dashboardLogout === "logout") {
                            return; // Skip further processing for Dashboard and Logout items
                        }
                        item.classList.remove("active");
                        item.classList.remove("disabled");
                        item.style.opacity = "1";
                        item.style.transform = "translateX(0)";
                        var collapse = item.querySelector(".collapse");
                        if (collapse) {
                            collapse.classList.remove("show");
                        }
                    });
                }
            }

            // Add event listener for input change
            document.getElementById("sidebar-search").addEventListener("input", searchSidebar);
            </script>


        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">

                <!-- Halaman dinamis -->
                <?php 
				error_reporting();
				$page= @$_GET['page'];
				$act = @$_GET['act'];
				if ($page=='data-umum') {
					// kelas
					if ($act=='kelas') {
					include '../admin/modul/kelas/date_kelas.php';
					}elseif ($act=='delkelas') {
					include '../admin/modul/kelas/delete.php';
					// semster
					}elseif ($act=='semester') {
					include '../admin/modul/semester/semester.php'; 
					}elseif ($act=='set_semester') {
						include '../admin/modul/semester/set.php';
					}
					// tahun ajaran
					elseif ($act=='tahun-ajaran') {
					include '../admin/modul/TahunAjaran/data.php'; 
					}elseif ($act=='delta') {
					include '../admin/modul/TahunAjaran/delete.php';
					}elseif($act=='setta'){
						include '../admin/modul/TahunAjaran/set.php';
						// mapel
				}elseif ($act=='mapel') {
					include '../admin/modul/mapel/data.php'; 
					}elseif ($act=='delmapel') {
					include '../admin/modul/mapel/delete.php';
					}					
				}
            elseif ($page=='guru') {
           if ($act=='') {
               include '../admin/Guru/data.php'; 
           }elseif ($act=='add') {
                include '../admin/Guru/tambah.php'; 
           }elseif ($act=='edit') {
               include '../admin/Guru/edit.php'; 
           }elseif ($act=='del') {
                include '../admin/Guru/del.php'; 
           }elseif ($act=='proses') {
                include '../admin/Guru/proses.php'; 
           }
        }elseif ($page=='siswa') {
          if ($act=='') {
               include '../admin/siswa/data.php'; 
           }elseif ($act=='add') {
                include '../admin/siswa/tambah.php'; 
           }elseif ($act=='edit') {
               include '../admin/siswa/edit.php'; 
           }elseif ($act=='del') {
                include '../admin/siswa/del.php'; 
           }elseif ($act=='proses') {
                include '../admin/siswa/proses.php'; 
           }   
        }
            elseif ($page=='rekap') {
					if ($act=='') {
						include '../admin/rekap/rekap_absen.php';
					}elseif ($act='rekap-perbulan') {
						include '../admin/rekap/rekap_perbulan.php';
					}					
		}elseif ($page=='jadwal') {
			if ($act=='') {
				include '../admin/jadwal/daftar.php';
			}elseif ($act=='add') {
				include '../admin/jadwal/tambah.php';
			}elseif ($act=='cancel') {
				include '../admin/jadwal/cancel.php';
			}					
		}elseif($page=='nilai'){
            if ($act==''){
                include '../admin/jadwal/absensi.php';
            }
        }elseif($page=='kelas') {
            include '../admin/rekap/rekap_absen.php';
        }elseif ($page=='') {
			include 'modul/home.php';
		}else{
			echo "<b>Tidak ada Halaman</b>";
		}
				?>

            </div>
            <footer class="footer dark-footer">
                <div class="container">
                    <div class="copyright ml-auto" style="margin-right: 150px;">
                        &copy; <?php echo date('Y');?> SMK N 6 SURAKARTA (<a href="main.php">Kelompok 4 </a> |
                        2024)
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Ganti Password -->
    <div class="modal fade bs-example-modal-sm" id="gantiPassword" tabindex="-1" role="dialog"
        aria-labelledby="gantiPass">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="background-color: rgba(57, 57, 57, 1); color: white;">
                <div class="modal-header">
                    <h4 class="modal-title" id="gantiPass">Ganti Password</h4>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label" style="color: white !important;">Password Lama</label>
                            <input name="passlama" type="text" class="form-control" placeholder="Password Lama"
                                style="background-color: rgba(57, 57, 57, 1); color: white; border-color: white;"
                                value="<?php $data['password'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label" style="color: white !important;">Password Baru</label>
                            <input name="passbaru" type="text" class="form-control" placeholder="Password Baru"
                                style="background-color: rgba(57, 57, 57, 1); color: white; border-color: white;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                            style="color: white; border-color: white;">Close</button>
                        <button name="changePassword" type="submit" class="btn btn-primary"
                            style="color: white; border-color: white !important;">Ganti Password</button>
                    </div>
                </form>
                <?php

?>




            </div>
        </div>
    </div>


    <!--end modal ganti password -->

    <!-- Modal pengaturan akun-->
    <div class=" modal fade" id="pengaturanAkun" tabindex="-1" role="dialog" aria-labelledby="akunAtur">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: rgba(57, 57, 57, 1); color: white;">
                <div class="modal-header">
                    <h3 class="modal-title" id="akunAtur" style="color: white;"><i class="fas fa-user-cog"></i>
                        Pengaturan Akun</h3>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label style="color: white !important;">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?=$data['nama_lengkap'] ?>"
                                style="background-color: rgba(57, 57, 57, 1); color: white; border-color: white;">
                            <input type="hidden" name="id" value="<?=$data['id_admin'] ?>">
                        </div>
                        <div class="form-group">
                            <label style="color: white !important;">Username</label>
                            <input type="text" name="username" class="form-control" value="<?=$data['usernames'] ?>"
                                style="background-color: rgba(57, 57, 57, 1); color: white; border-color: white;">
                        </div>
                        <div class="form-group">
                            <label style="color: white !important;">Foto Profile</label>
                            <p>
                                <img src="../admin/photo-profiles/<?=$data['profiles'] ?>"
                                    style="height: 50px;width: 50px;">
                            </p>
                            <input type="file" name="foto"
                                style="color: black; background-color: rgba(57, 57, 57, 1); color: white; border-color: white;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                            style="color: white; border-color: white;">Close</button>
                        <button name="updateProfile" type="submit" class="btn btn-primary"
                            style="color: white; border-color: white  !important;;">Simpan</button>
                    </div>
                </form>
                <?php 

?>

            </div>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="../admin/assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="../admin/assets/js/core/popper.min.js"></script>
    <script src="../admin/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="../admin/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../admin/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js">
    </script>

    <!-- jQuery Scrollbar -->
    <script src="../admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Datatables -->
    <script src="../admin/assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Sweet Alert -->
    <script src="../admin/assets/js/plugin/sweetalert/sweetalert.min.js"></script>



    <!-- Atlantis JS -->
    <script src="../admin/assets/js/atlantis.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({});

        $('#multi-filter-select').DataTable({
            "pageLength": 5,
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $(
                            '<select class="form-control"><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util
                                .escapeRegex(
                                    $(this).val()
                                );

                            column
                                .search(val ? '^' + val + '$' : '',
                                    true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d +
                            '">' + d +
                            '</option>')
                    });
                });
            }
        });

        // Add Row
        $('#add-row').DataTable({
            "pageLength": 5,
        });

        var action =
            '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $('#addRowButton').click(function() {
            $('#add-row').dataTable().fnAddData([
                $("#addName").val(),
                $("#addPosition").val(),
                $("#addOffice").val(),
                action
            ]);
            $('#addRowModal').modal('hide');

        });
    });
    </script>
</body>

</html>