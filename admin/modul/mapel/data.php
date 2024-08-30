<style>
.breadcrumbs li a {
    color: white;
}

.page-title {
    color: white;
}

.card {
    background-color: rgba(36, 36, 44, 0.9);
}
</style>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Mata Pelajaran</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="main.php">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a href="#">Data Umum</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a href="#">Daftar Mata Pelajaran</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="" class="btn btn-primary btn-sm text-white" data-toggle="modal"
                            data-target="#addKelas"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">KODE PELAJARAN</th>
                                    <th scope="col">NAMA PELAJARAN</th>
                                    <th scope="col">OPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                        $no=1;
                        $mapel = mysqli_query($koneksi,"SELECT * FROM mapel");
                        foreach ($mapel as $k) {?>
                                <tr>
                                    <td><b><?=$no++;?>.</b></td>
                                    <td><?=$k['id_buku'];?>-<?=$k['jenis']?></td>
                                    <td><?=$k['nama_buku'];?></td>
                                    <td>

                                        <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#edit<?=$k['id'] ?>"><i class="far fa-edit"></i> Edit</a>
                                        <a class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin Menghapus Data ??')"
                                            href="?page=data-umum&act=delmapel&id=<?=$k['id'] ?>"><i
                                                class="fas fa-trash"></i> Delete</a>
                                        <!-- Modal -->
                                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog"
                                            tabindex="-1" id="edit<?=$k['id'] ?>" class="modal fade"
                                            style="display: none;">
                                            <div class="modal-dialog" style="max-width: 400px;">
                                                <div class="modal-content"
                                                    style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                                                    <div class="modal-header">
                                                        <h4 id="exampleModalLabel" class="modal-title">Edit Pelajaran
                                                        </h4>
                                                        <button type="button" data-dismiss="modal" aria-label="Close"
                                                            class="close" style="color: white;"><span
                                                                aria-hidden="true">×</span></button>

                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <center><label style="color: white !important;">Mata
                                                                            Pelajaran</label></center>
                                                                    <div class="input-group mb-3">
                                                                        <input name="id" type="hidden"
                                                                            value="<?=$k['id']?>">
                                                                        <select class="form-select"
                                                                            aria-label="Dropdown select" name="jenis"
                                                                            style="flex: 0 1 70px; background-color: rgba(36, 36, 44, 0.9); color: white; border-color: white;"
                                                                            required>
                                                                            <?php 
                                                                            $jenis_options = ['A', 'B']; // Asumsikan pilihan yang ada
                                                                            foreach($jenis_options as $option): 
                                                                            ?>
                                                                            <option value="<?= $option ?>"
                                                                                <?= ($option == $k['jenis']) ? 'selected' : '' ?>>
                                                                                <?= $option ?>
                                                                            </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input name="mapel" type="text"
                                                                            value="<?=$k['nama_buku']?>"
                                                                            class="form-control"
                                                                            aria-label="Text input with dropdown select"
                                                                            style="background-color: rgba(36, 36, 44, 0.9); color: white; border-color: white;"
                                                                            required>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button name="edit"
                                                                            class="btn btn-primary btn-block btn-sm"
                                                                            type="submit">Edit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <?php
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $mapel = $_POST['mapel'];
    $jenis = $_POST['jenis'];

    $save = mysqli_query($koneksi, "UPDATE mapel SET nama_buku='$mapel', jenis='$jenis' WHERE id='$id'");
    if ($save) {
        echo "<script>
        alert('Data diubah!');
        window.location='?page=data-umum&act=mapel';
        </script>";                        
    } else {
        echo "<script>
        alert('Data gagal diubah!');
        window.location='?page=data-umum&act=mapel';
        </script>";  
    }
}
?>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal "Tambah Kelas" -->
            <div id="addKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                class="modal fade text-left">
                <div role="document" class="modal-dialog modal-lg">
                    <div class="modal-content" style="background-color: rgba(36, 36, 44, 0.9); color: white;">
                        <div class="modal-header">
                            <h4 id="exampleModalLabel" class="modal-title">Tambah Pelajaran</h4>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <?php
// Ambil kode buku terakhir dari database
$query_last_code = "SELECT id_buku FROM mapel ORDER BY id DESC LIMIT 1";
$result_last_code = mysqli_query($koneksi, $query_last_code);
if ($row_last_code = mysqli_fetch_assoc($result_last_code)) {
    $last_code = $row_last_code['id_buku'];

    // Ekstrak nomor urut dari kode buku terakhir
    preg_match('/(\d+)$/', $last_code, $matches);
    $last_number = intval($matches[0]);

    // Tambahkan 1 ke nomor urut
    $next_number = $last_number + 1;

    // Format ulang kode buku berikutnya
    $next_code = preg_replace('/\d+$/', sprintf("%03d", $next_number), $last_code);
} else {
    // Jika tidak ada kode buku sebelumnya, set default
    $next_code = "BK001";
}
?><div class="row">
                                        <div class="col-md-12">
                                            <center><label style="color: white !important;">Kode Pelajaran</label>
                                            </center>
                                            <div class="input-group mb-3">
                                                <input name="kode" type="text" value="<?php echo $next_code; ?>"
                                                    class="form-control"
                                                    style="background-color: rgba(36, 36, 44, 0.9); color: black;"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="" method="post" class="form-horizontal">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <center><label style="color: white !important;">Mata Pelajaran</label>
                                                </center>
                                                <div class="input-group mb-3">
                                                    <input name="id" type="hidden">
                                                    <select class="form-select" aria-label="Dropdown select"
                                                        name="jenis"
                                                        style="flex: 0 1 70px; background-color: rgba(36, 36, 44, 0.9); color: white; border-color: white;"
                                                        required>
                                                        <?php 
                    $jenis_options = ['A', 'B']; // Asumsikan pilihan yang ada
                    foreach($jenis_options as $option): 
                    ?>
                                                        <option value="<?= $option ?>"> <?=$option?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <input name="mapel" type="text" class="form-control"
                                                        aria-label="Text input with dropdown select"
                                                        placeholder="Nama Pelajaran .."
                                                        style="background-color: rgba(36, 36, 44, 0.9); color: white; border-color: white;"
                                                        required>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row" style="text-align: right;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button name="save" class="btn btn-primary"
                                                        type="submit">Simpan</button>
                                                    <button type="button" data-dismiss="modal"
                                                        class="btn btn-secondary">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>


                                    <?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    // Check if the necessary data is set
    if (isset($_POST['kode'], $_POST['mapel'])) {
        // Prepare the data for insertion
        $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
        $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);
        $jenis = mysqli_real_escape_string($koneksi, $_POST['jenis']);

        // Perform the insertion query
        $query = "INSERT INTO mapel (id_buku, nama_buku , jenis) VALUES ('$kode', '$mapel','$jenis')";
        $result = mysqli_query($koneksi, $query);

        // Check if the insertion was successful
        if ($result) {
            echo "<script>
            alert('Data tersimpan !');
            window.location='?page=data-umum&act=mapel';
            </script>";
        } else {
            // Handle insertion error
            echo "<script>alert('Gagal menyimpan data!');</script>";
        }
    } else {
        // Handle missing data
        echo "<script>alert('Data tidak lengkap!');</script>";
    }
}
?>

                                </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
        </div>
    </div>