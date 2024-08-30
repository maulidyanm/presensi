<?php 
// Pastikan parameter 'id' tersedia di URL
if (isset($_GET['id'])) {
    // Bersihkan input 'id' dari potensi serangan SQL injection
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Lakukan query untuk menghapus data berdasarkan 'id' yang diberikan
    $del = mysqli_query($koneksi, "DELETE FROM ajaran WHERE id='$id'");
    
    // Periksa apakah penghapusan berhasil
    if ($del) {
        echo "<script>
            alert('Data telah dihapus !');
            window.location='?page=data-umum&act=tahun-ajaran';
        </script>";	
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "Parameter 'id' tidak ditemukan.";
}
?>