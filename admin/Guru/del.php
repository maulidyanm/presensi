<?php
// Persiapkan pernyataan DELETE menggunakan prepared statement
$del = mysqli_prepare($koneksi, "DELETE FROM tbl_staff WHERE id_staff = ?");
// Periksa apakah persiapan berhasil
if ($del) {
    // Bind parameter ke placeholder
    mysqli_stmt_bind_param($del, "s", $_GET['id']);
    // Eksekusi pernyataan
    mysqli_stmt_execute($del);
    // Periksa apakah penghapusan berhasil
    if (mysqli_stmt_affected_rows($del) > 0) {
        echo "<script>
        alert('Data telah dihapus !');
        window.location='?page=guru';
        </script>";
    } else {
        echo "<script>
        alert('Gagal menghapus data.');
        window.location='?page=guru';
        </script>";
    }
} else {
    echo "<script>
    alert('Gagal membuat pernyataan SQL.');
    window.location='?page=guru';
    </script>";
}
?>