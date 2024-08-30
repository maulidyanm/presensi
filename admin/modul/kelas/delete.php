<?php 
if (isset($_GET['id'])) {
    $id_kelas = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Lakukan penghapusan referensi id_kelas dari tabel siswa
    $del_siswa = mysqli_query($koneksi, "UPDATE tbl_siswa SET kelas = NULL WHERE kelas = '$id_kelas'");

    // Periksa apakah penghapusan berhasil
    if ($del_siswa) {
        // Lakukan penghapusan dari tabel kelas
        $del_kelas = mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id_kelas'");

        // Periksa apakah penghapusan kelas berhasil
        if ($del_kelas) {
            echo "<script>
                alert('Data telah dihapus !');
                window.location='?page=data-umum&act=kelas';
            </script>";
        } else {
            echo "Gagal menghapus data kelas.";
        }
    } else {
        echo "Gagal menghapus referensi id_kelas dari tabel siswa.";
    }
} else {
    echo "Parameter 'id' tidak ditemukan.";
}
?>