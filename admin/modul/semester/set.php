<?php 
// Assuming $koneksi is your database connection

// Check if 'id' and 'aktif' parameters are set in the URL
if (isset($_GET['id']) && isset($_GET['aktif'])) {
    $id = $_GET['id'];
    $aktif = $_GET['aktif'];

    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($koneksi, $id);
    $aktif = mysqli_real_escape_string($koneksi, $aktif);
    if ($aktif == 0) {
        // Set the selected semester to inactive
        mysqli_query($koneksi, "UPDATE semester SET aktif=0 WHERE id='$id'");
        echo "<script>window.location='?page=data-umum&act=semester';</script>";
    } elseif ($aktif == 1) {
        // Set all semesters to inactive except the selected one
        mysqli_query($koneksi, "UPDATE semester SET aktif=0 WHERE id<>'$id'");
        // Set the selected semester to active
        mysqli_query($koneksi, "UPDATE semester SET aktif=1 WHERE id='$id'");
        echo "<script>window.location='?page=data-umum&act=semester';</script>";
    } else {
        // Invalid 'aktif' value
        echo "Nilai 'aktif' tidak valid.";
    }
} else {
    echo "Parameter 'id' atau 'aktif' tidak ditemukan.";
}
?>