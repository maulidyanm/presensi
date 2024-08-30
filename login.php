<?php
session_start();
include '../kelompok4/koneksi/koneksi.php';

// Initialize the $database object
$database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));

// Inisialisasi variabel untuk pesan kesalahan
$login_error = "";

// Inisialisasi variabel untuk menandai apakah terjadi kesalahan saat login
$login_failed = false;

// Cek apakah ada pesan kesalahan sebelumnya yang tersimpan di session
if (isset($_SESSION['login_failed']) && $_SESSION['login_failed'] == true) {
    // Jika ada, set nilai $login_failed menjadi true
    $login_failed = true;
    // Simpan pesan kesalahan ke variabel lokal
    $login_error = $_SESSION['login_error'];
    // Hapus pesan kesalahan dari session
    unset($_SESSION['login_error']);
    unset($_SESSION['login_failed']);
}

// Logika validasi form login
if (isset($_POST['login']) && $_POST['login'] == 'check') {
    // Ambil nilai username dan password dari form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query untuk memeriksa apakah username cocok
    $query_admin = "SELECT * FROM administrator WHERE usernames = '$username'";
    $query_guru = "SELECT * FROM tbl_staff WHERE id_staff = '$username'";

    // Check if the connection is successful before executing the query
    if ($database) {
        $result_admin = mysqli_query($database, $query_admin);
        $result_guru = mysqli_query($database, $query_guru);

        // Periksa apakah hasil query untuk admin menghasilkan satu baris
        if ($result_admin && mysqli_num_rows($result_admin) == 1) {
            // Ambil data pengguna admin
            $user_data = mysqli_fetch_assoc($result_admin);
            // Memeriksa apakah password cocok
            if (password_verify($password, $user_data['password'])) {
                // Simpan username pengguna ke dalam session
                $_SESSION['admin'] = $user_data['usernames'];
                // Simpan nama lengkap ke dalam session
                $_SESSION['nama_lengkap'] = $user_data['nama_lengkap'];
                // Login berhasil, arahkan kembali ke login_succes.php dengan pesan sukses
                header('location:../kelompok4/admin/login_succes.php');
                exit; // Pastikan untuk keluar dari skrip setelah mengalihkan pengguna
            }
        } elseif ($result_guru && mysqli_num_rows($result_guru) == 1) {
            // Ambil data pengguna guru
            $user_data = mysqli_fetch_assoc($result_guru);
            // Memeriksa apakah password cocok
            if (password_verify($password, $user_data['password'])) {
                // Simpan username pengguna ke dalam session
                $_SESSION['id_staff'] = $user_data['id_staff'];
                // Simpan nama lengkap ke dalam session
                $_SESSION['nama'] = $user_data['nama'];
                // Login berhasil, arahkan kembali ke login_succes.php dengan pesan sukses
                header('location:../kelompok4/guru/login_succes.php');
                exit; // Pastikan untuk keluar dari skrip setelah mengalihkan pengguna
            }
        }

        // Jika tidak ada hasil dari query atau password tidak cocok
        // Login gagal, simpan pesan kesalahan
        $_SESSION['login_error'] = "Login gagal. Periksa kembali username dan password Anda.";
        $_SESSION['login_failed'] = true;
        // Redirect back to the login page
        header('location:login.php');
        exit;
    } else {
        echo "Failed to connect to the database.";
    }
}
unset($_SESSION['login_failed']);
unset($_SESSION['login_error']);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="asset/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link rel="stylesheet" type="text/css" href="../kelompok 4/assets/_login/css/util.css">
    <link rel="stylesheet" type="text/css" href="../kelompok 4/assets/_login/css/main.css">
    <link rel="stylesheet" type="text/css"
        href="../kelompok 4/assets/_login/fonts/iconic/css/material-design-iconic-font.min.css">
    <title>Presensi | Login</title>
    <style>
    body {
        background-image: url('../kelompok4/admin/asset/background/BG.jpg');
        background-size: cover;
        background-position: center;
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-container {
        margin-left: 30px;
        text-align: center;
        /* Pusatkan teks di dalam container */
        padding: 20px;
        max-width: 400px;
        /* Batasi lebar maksimum elemen login */
        width: 100%;
        /* Agar lebar sesuai dengan konten di dalamnya */
    }

    .logo {
        margin-bottom: 20px;
        /* Tambahkan margin bawah untuk jarak antara logo dan form */
    }

    h3 {
        color: white;
        font-family: Monaco;
        font-weight: bold;
    }

    .form-floating {
        margin-bottom: 1rem;
    }

    .is-invalid {
        border-color: red;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="logo.png" alt="Logo" width="150"> <!-- Ubah "logo.png" dengan path ke file logo Anda -->
            <h3>PRESENSI</h3>
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-floating">
                <input type="text" class="form-control" id="username" name="username"
                    placeholder="Enter Your Teacher ID" value="<?php echo isset($username) ? $username : ''; ?>">
                <label for="username">Teacher ID</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control <?php if ($login_failed) echo 'is-invalid'; ?>" id="password"
                    name="password" placeholder="Password">
                <span class="btn-show-pass" onclick="showpassword()">
                    <i class="zmdi zmdi-eye"></i>
                </span>
                <label for="password">Password</label>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Ambil elemen password
                    var passwordField = document.getElementById('password');
                    // Ambil ikon show password
                    var showPasswordIcon = document.querySelector('.btn-show-pass i');

                    // Hapus kelas is-invalid saat form di-submit ulang
                    passwordField.addEventListener('input', function() {
                        if (passwordField.classList.contains('is-invalid')) {
                            passwordField.classList.remove('is-invalid');
                            // Kembalikan ikon zmdi-eye saat is-invalid hilang
                            showPasswordIcon.classList.remove('zmdi-eye-off');
                            showPasswordIcon.classList.add('zmdi-eye');
                        }
                    });

                    // Fungsi untuk menampilkan atau menyembunyikan password
                    function showPassword() {
                        if (passwordField.type === "password") {
                            passwordField.type = "text";
                            showPasswordIcon.classList.remove('zmdi-eye');
                            showPasswordIcon.classList.add('zmdi-eye-off');
                        } else {
                            passwordField.type = "password";
                            showPasswordIcon.classList.remove('zmdi-eye-off');
                            showPasswordIcon.classList.add('zmdi-eye');
                        }
                    }

                    // Tambahkan event listener untuk icon show password
                    document.querySelector('.btn-show-pass').addEventListener('click', function() {
                        showPassword();
                    });
                });
                </script>
                <?php if ($login_failed) : ?>
                <div class="invalid-feedback" id="error-message"><?php echo $login_error; ?></div>
                <script>
                // Hide error message after 5 seconds
                setTimeout(function() {
                    var errorMessage = document.getElementById('error-message');
                    if (errorMessage) {
                        errorMessage.style.display = 'none';
                    }
                }, 5000);
                // Dapatkan tombol untuk berpindah slide
                var slideButton = document.getElementById('button-slide');
                // Tambahkan event listener untuk klik pada tombol
                slideButton.addEventListener('click', function() {
                    // Hilangkan kelas .is-invalid dari semua elemen dengan kelas tersebut
                    var invalidElements = document.querySelectorAll('.is-invalid');
                    invalidElements.forEach(function(element) {
                        element.classList.remove('is-invalid');
                    });
                });
                </script>
                <?php endif; ?>
            </div>
            <div class="form-group" style="margin-top: 20px;" align="center">
                <button type="submit" name="login" value="check" class="btn btn-primary btn-block">LOGIN</button>
            </div>
        </form>
    </div>
</body>

</html>