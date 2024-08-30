<?php 
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    // Periksa apakah penghapusan berhasil
    if ($id) {
        // Lakukan penghapusan dari tabel kelas
        $del = mysqli_query($koneksi, "DELETE FROM jadwal_pengajar WHERE id_jadwal='$id'");

        // Periksa apakah penghapusan kelas berhasil
        if ($del) {
            echo "<script>
                alert('cancelled successfully');
               window.location='?page=jadwal';
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