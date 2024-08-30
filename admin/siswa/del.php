<?php
// Mengambil nama siswa dari database berdasarkan id_siswa
$query_nama_siswa = mysqli_query($koneksi, "SELECT nama FROM tbl_siswa WHERE id_siswa = $_GET[id]");
$data_nama_siswa = mysqli_fetch_assoc($query_nama_siswa);

// Menghapus siswa dari database
$del = mysqli_query($koneksi, "DELETE FROM tbl_siswa WHERE id_siswa = $_GET[id]");

if ($del) {
    // Jika penghapusan berhasil, tampilkan pesan sukses dengan nama siswa
    echo "
    <script type='text/javascript'>
    setTimeout(function () { 
        alert('$data_nama_siswa[nama] Berhasil dihapus!');
    }, 10);  
    window.setTimeout(function(){ 
        window.location.replace('?page=siswa');
    }, 800);   
    </script>";
}
?>