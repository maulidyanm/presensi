<?php 

if (isset($_POST['saveSiswa'])) {
    

    
        $save = mysqli_query($koneksi, "INSERT INTO tbl_siswa VALUES(NULL,'$_POST[nama]','$_POST[kelas]','$_POST[nis]','Y','$_POST[jk]','$nama_gambar','$_POST[th_masuk]') ");
        if ($save) {
            echo "
    <script type='text/javascript'>
    setTimeout(function () { 
        alert('$_POST[nama] Berhasil disimpan');
    }, 10);  
    window.setTimeout(function(){ 
        window.location.replace('?page=siswa');
    }, 800);   
    </script>";
        }
    
}
elseif (isset($_POST['editSiswa'])) {

  		$gambar = @$_FILES['foto']['name'];
		if (!empty($gambar)) {
		move_uploaded_file($_FILES['foto']['tmp_name'],"../admin/photo-profiles/$gambar");
		$ganti = mysqli_query($koneksi,"UPDATE tbl_siswa SET profiles='$gambar' WHERE id_siswa='$_POST[id]' ");
		}
$tempat_lahir = $_POST['tempat']; // Ubah variabel untuk menyesuaikan
$editSiswa = mysqli_query($koneksi, "UPDATE tbl_siswa SET nama='$_POST[nama]', gender='$_POST[jk]', kelas='$_POST[kelas]', angkatan='$_POST[th_masuk]' WHERE id_siswa='$_POST[id]'");


		if ($editSiswa) {
				 echo "
    <script type='text/javascript'>
    setTimeout(function () { 
        alert('$_POST[nama] Berhasil diubah!');
    }, 10);  
    window.setTimeout(function(){ 
        window.location.replace('?page=siswa');
    }, 800);   
    </script>";
		}
  }
 ?>