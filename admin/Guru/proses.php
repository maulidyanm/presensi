<?php
session_start();
if (isset($_POST['saveGuru'])) {
    $pass = $_POST['nip'];
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $sumber = @$_FILES['foto']['tmp_name'];
    $target = '../admin/photo-profiles/';
    $nama_gambar = @$_FILES['foto']['name'];
    $pindah = move_uploaded_file($sumber, $target . $nama_gambar);

    // Check for duplicate NIP
    $query = mysqli_query($koneksi, "SELECT id_staff FROM tbl_staff WHERE id_staff = '$_POST[nip]'");
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['duplicateError'] = true;
        echo "
        <script type='text/javascript'>
        setTimeout(function () { 
            alert('Gagal disimpan. ID Guru $_POST[nip] sudah ada');
        }, 10);  
        window.setTimeout(function(){ 
            window.history.back();
        }, 800);   
        </script>";
    } else {
        if ($pindah) {
            $duplicateError = false;
            $save = mysqli_query($koneksi, "INSERT INTO tbl_staff (id_staff, nama, email, status, profil, password) VALUES ('$_POST[nip]', '$_POST[nama]', '$_POST[email]', 'Y', '$nama_gambar', '$hashed_password')");

            if ($save) {
                echo "
                <script type='text/javascript'>
                setTimeout(function () { 
                    alert('$_POST[nama] Berhasil disimpan');
                }, 10);  
                window.setTimeout(function(){ 
                    window.location.replace('?page=guru');
                }, 800);   
                </script>";
            }
        }
    }
} elseif (isset($_POST['editGuru'])) {
    $gambar = @$_FILES['foto']['name'];
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    // Check if new image uploaded
    if (!empty($gambar)) {
        move_uploaded_file($_FILES['foto']['tmp_name'], "../admin/photo-profiles/$gambar");
        $updateProfil = mysqli_query($koneksi, "UPDATE tbl_staff SET profil='$gambar' WHERE id_staff='$id'");
    }

    // Update name and email
    $editGuru = mysqli_query($koneksi, "UPDATE tbl_staff SET nama='$nama', email='$email' WHERE id_staff='$id'");

    if ($editGuru) {
        echo "
        <script type='text/javascript'>
        setTimeout(function () { 
            alert('$nama Berhasil diubah');
        }, 10);  
        window.setTimeout(function(){ 
            window.location.replace('?page=guru');
        }, 800);   
        </script>";
    }
}
?>