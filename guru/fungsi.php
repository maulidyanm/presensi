<?php
include '../koneksi/koneksi.php';

// Initialize the $database object


function login($id_staff, $password)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    $query = "SELECT password, nama, id_staff FROM tbl_staff WHERE id_staff = '" . $id_staff . "' and status = 'Y'";
    $result = mysqli_query($database, $query);



    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($row['password'] == hash($password)) {
            $return = array(
                'status' => true,
                'id_staff' => $row['id_staff'],
                'nama' => $row['nama'],
                'msg' => 'Berhasil login'
            );

        } else {
            $return = array('status' => false, 'msg' => 'Password tidak sesuai');
        }
    } else {
        $return = array('status' => false, 'msg' => 'User tidak ditemukan atau tidak aktif');
    }
    return $return;
}
// muhariya.12

function get_kelas_presensi($id_staff)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    $query = "SELECT distinct kelas, pelajaran FROM jadwal_pengajar WHERE id_staff = '" . $id_staff . "' ";
    $query .= "AND jenis_jadwal = case when MOD ( WEEK(CURDATE(), 5) - WEEK(DATE_SUB(CURDATE(), ";
    $query .= "INTERVAL DAYOFMONTH (CURDATE()) - 1 DAY), 5) + 1, 2) = 1 then 'A' ELSE 'B' end";
    $result = mysqli_query($database, $query);

    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return array('data' => $row);
}


function get_kelas_rekap($id_staff)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    $query = "SELECT distinct kelas, pelajaran FROM jadwal_pengajar WHERE id_staff = '" . $id_staff . "' ";
    $result = mysqli_query($database, $query);

    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return array('data' => $row);
}

function get_data_guru($id_staff)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    $sql = mysqli_query($database, "SELECT * FROM tbl_staff WHERE id_staff = '$id_staff'");
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    return array('data' => $data);
}

function siswa($kelas)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    $sql = mysqli_query($database, "SELECT * FROM tbl_siswa WHERE kelas = '$kelas'");
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    return array('data' => $data);
}

function upsert_absen($data)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));

    if (is_null($data['tanggal']) || $data['tanggal'] == '') {
        $tanggal_data = "CURDATE()";
    } else {
        $tanggal = mysqli_real_escape_string($database, $data['tanggal']);
        $tanggal_data = "STR_TO_DATE('$tanggal', '%Y-%m-%d')";
    }

    // Escape nilai untuk menghindari SQL injection
    $id_siswa = mysqli_real_escape_string($database, $data['id_siswa']);
    $id_staff = mysqli_real_escape_string($database, $data['id_staff']);
    $status = mysqli_real_escape_string($database, $data['status']);
    $keterangan = mysqli_real_escape_string($database, $data['keterangan']);

    $sql = "INSERT INTO tbl_transaksi_hadir (tanggal_transaksi, id_siswa, id_staff, status, keterangan, waktu_presensi) ";
    $sql .= "VALUES ($tanggal_data, '$id_siswa', '$id_staff', '$status', '$keterangan', NOW()) ";
    $sql .= "ON DUPLICATE KEY UPDATE status='$status', keterangan='$keterangan', waktu_presensi=NOW()";

    $file = 'log3.txt';
    file_put_contents($file, print_r($sql, true));

    if ($database->query($sql) === TRUE) {
        return array('msg' => 'Data berhasil disimpan');
    } else {
        return array('msg' => 'Data gagal disimpan, reason: ' . $database->error);
    }
}



function get_absen($id_staff, $id_siswa, $tanggal)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    if (is_null($tanggal)) {
        $tanggal_data = "CURDATE()";
    } else {
        $tanggal_data = "STR_TO_DATE('$tanggal', '%Y-%m-%d')";
    }

    $query = "SELECT status, keterangan ";
    $query .= "FROM tbl_transaksi_hadir WHERE id_staff= '$id_staff' ";
    $query .= "AND id_siswa= $id_siswa and tanggal_transaksi=$tanggal_data";
    $sql = mysqli_query($database, $query);
    $data = mysqli_fetch_array($sql, MYSQLI_ASSOC);

    return array('data' => $data);
}

function jadwal($id_staff, $tanggal_mulai)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    $query = "SELECT hari_mengajar,";
    $query .= "TIME_FORMAT(mulai_mengajar, '%H:%i') as mulai_mengajar, ";
    $query .= "TIME_FORMAT(akhir_mengajar, '%H:%i') as akhir_mengajar, ";
    $query .= "kelas, pelajaran ";
    $query .= "FROM jadwal_pengajar WHERE id_staff='$id_staff' ";
    $query .= "and jenis_jadwal = case when MOD ( WEEK(STR_TO_DATE('$tanggal_mulai', '%Y-%m-%d'), 5) ";
    $query .= "- WEEK(DATE_SUB(STR_TO_DATE('$tanggal_mulai', '%Y-%m-%d'), ";
    $query .= "INTERVAL DAYOFMONTH (STR_TO_DATE('$tanggal_mulai', '%Y-%m-%d')) - 1 DAY), 5) + 1, 2) = 1 ";
    $query .= "then 'A' ELSE 'B' end order by hari_mengajar, mulai_mengajar";
    $sql = mysqli_query($database, $query);
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    return array('data' => $data);
}

function rekap_by_kelas($id_staff, $kelas, $bulan)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    $query = "SELECT a.tanggal_transaksi,";
    $query .= "a.id_staff, ";
    $query .= "b.kelas, ";
    $query .= "COUNT(IF(a.status = 'H', 1, NULL)) AS hadir, ";
    $query .= "COUNT(IF(a.status = 'S', 1, NULL)) AS sakit, ";
    $query .= "COUNT(IF(a.status = 'I', 1, NULL)) AS ijin, ";
    $query .= "COUNT(IF(a.status = 'A', 1, NULL)) AS alpha, ";
    $query .= "COUNT(IF(a.status = 'H', 1, NULL)) + COUNT(IF(a.status = 'S', 1, NULL)) + ";
    $query .= "COUNT(IF(a.status = 'I', 1, NULL)) + COUNT(IF(a.status = 'A', 1, NULL)) AS total_absen, ";
    $query .= "(SELECT COUNT(1) FROM tbl_siswa WHERE kelas = '$kelas') AS jumlah_siswa ";
    $query .= "FROM tbl_transaksi_hadir a, tbl_siswa b ";
    $query .= "WHERE a.id_staff='$id_staff' ";
    $query .= "AND b.kelas = '$kelas' ";
    $query .= "AND a.id_siswa = b.id_siswa ";
    $query .= "AND MONTH(a.tanggal_transaksi) = MONTH(STR_TO_DATE(CONCAT('$bulan','-01'), '%Y-%m-%d'))";
    $query .= "AND YEAR(a.tanggal_transaksi) = YEAR(STR_TO_DATE(CONCAT('$bulan','-01'), '%Y-%m-%d'))";
    $query .= "GROUP BY a.tanggal_transaksi, a.id_staff";
    $sql = mysqli_query($database, $query);
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    return array('data' => $data);
}

function get_tanggal($id_kelas, $id_staff)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    $query = "SELECT a.tanggal_transaksi ";
    $query .= "FROM tbl_transaksi_hadir a, ";
    $query .= "tbl_siswa b ";
    $query .= "WHERE a.id_siswa = b.id_siswa ";
    $query .= "AND b.kelas = '$id_kelas' ";
    $query .= "AND a.id_staff='$id_staff' GROUP BY a.tanggal_transaksi ";
    $file = 'log3.txt';
    file_put_contents($file, print_r($query, true));
    $sql = mysqli_query($database, $query);
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    return array('data' => $data);
}

function get_rekap($id_staff, $kelas, $tanggal)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    $query = "SELECT b.kelas, b.nama, b.nis,";
    $query .= "case when a.`status` = 'H' then 'Hadir'";
    $query .= "     when a.`status` = 'S' then 'Sakit'";
    $query .= "     when a.`status` = 'I' then 'Ijin'";
    $query .= "        ELSE 'Alpha' ";
    $query .= "        END AS status,";
    $query .= "if(a.keterangan = '', ' - ', a.keterangan) AS keterangan ";
    $query .= "FROM tbl_transaksi_hadir a,";
    $query .= "        tbl_siswa b ";
    $query .= "WHERE a.id_siswa = b.id_siswa ";
    $query .= "AND b.kelas = '$kelas' ";
    $query .= "AND a.id_staff='$id_staff' ";
    $query .= "AND a.tanggal_transaksi = STR_TO_DATE('$tanggal', '%Y-%m-%d')";

    $sql = mysqli_query($database, $query);
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    return array('data' => $data);
}

function upload_profil($id_staff, $file)
{
    $database = new mysqli("localhost", "root", "", "presensi") or die(mysqli_error($koneksi));
    move_uploaded_file($file['foto']['tmp_name'], "assets/img/user/$id_staff.png");
    $query = "UPDATE tbl_staff SET profil = '$id_staff.png' WHERE id_staff='$id_staff'";
    if ($database->query($query) === TRUE) {
        return array('msg' => 'Data berhasil disimpan');
    } else {
        return array('msg' => 'Data gagal disimpan, reason: ' . $database->error);
    }
}

function update_password($id_staff, $form)
{
    // Buat koneksi ke database
    $database = new mysqli("localhost", "root", "", "presensi");
    if ($database->connect_error) {
        die("Koneksi gagal: " . $database->connect_error);
    }

    // Dapatkan password baru dari form
    $password_baru = $form['pass1'];

    // Query untuk mendapatkan data staff berdasarkan id_staff
    $query = "SELECT password, nama, id_staff FROM tbl_staff WHERE id_staff = ? AND status = 'Y'";
    $stmt = $database->prepare($query);
    $stmt->bind_param("s", $id_staff);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Periksa apakah password baru dan konfirmasi password sesuai
    if ($password_baru == $form['pass2']) {
        if ($row = $result->fetch_assoc()) {
            // Verifikasi password lama
            if (password_verify($form['pass'], $row['password'])) {
                // Hash password baru
                $password_baru_hashed = password_hash($password_baru, PASSWORD_DEFAULT);

                // Query untuk mengupdate password
                $update_query = "UPDATE tbl_staff SET password = ? WHERE id_staff = ?";
                $update_stmt = $database->prepare($update_query);
                $update_stmt->bind_param("ss", $password_baru_hashed, $id_staff);

                // Eksekusi query dan cek hasilnya
                if ($update_stmt->execute()) {
                    return array('msg' => 'Password berhasil diubah');
                } else {
                    return array('msg' => 'Password gagal diubah, reason: ' . $database->error);
                }
            } else {
                return array('msg' => 'Password Lama Salah');
            }
        } else {
            return array('msg' => 'Staff tidak ditemukan atau tidak aktif');
        }
    } else {
        return array('msg' => 'Password Baru dan Password Konfirmasi Tidak Sesuai');
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('php://input');
    $datum = json_decode($jsonData, true);
    if (isset($datum['action'])) {
        if ($datum['action'] == 'jadwal') {
            if (isset($datum['id_staff']) && isset($datum['tanggal_mulai'])) {
                header('Content-Type: application/json; charset=utf-8');

                $data = jadwal($datum['id_staff'], $datum['tanggal_mulai']);
                echo json_encode($data);
            }
        } elseif ($datum['action'] == 'download') {
            require ('assets/library/fpdf.php');
            $pdf = new FPDF();


            if ($datum['tanggal'] == 'ALL') {
                $semua_tanggal = get_tanggal($datum['id_kelas'], $datum['id_staff']);

            } else {
                $semua_tanggal = array('data' => array(array('tanggal_transaksi' => $datum['tanggal'])));

            }

            foreach ($semua_tanggal['data'] as $data_tgl) {

                $pdf->AddPage();
                $data = get_rekap($datum['id_staff'], $datum['id_kelas'], $data_tgl['tanggal_transaksi']);

                $var_kelas = $datum['id_kelas'];
                $var_tanggal = $data_tgl['tanggal_transaksi'];

                $data_pdf = $data['data'];

                $pdf->SetFont('Times', 'B', 20);

                // Framed rectangular area 
                $pdf->Cell(176, 5, 'Absensi kelas ' . $var_kelas, 0, 0, 'C');

                // Set it new line 
                $pdf->Ln();

                // Set font format and font-size 
                $pdf->SetFont('Times', 'B', 12);

                // Framed rectangular area 
                $pdf->Cell(176, 10, 'Tanggal, ' . $var_tanggal, 0, 0, 'C');
                $pdf->SetFont('Times', '', 10);
                $pdf->Ln();
                $pdf->Cell(20, 10, 'NIS', 1, 0);
                $pdf->Cell(96, 10, 'NAMA', 1, 0, );
                $pdf->Cell(24, 10, 'STATUS', 1, 0, );
                $pdf->Cell(44, 10, 'KETERANGAN', 1, 0, );
                $pdf->Ln();
                foreach ($data_pdf as $dp) {
                    $pdf->Cell(20, 10, $dp['nis'], 1, 0, 'L');
                    $pdf->Cell(96, 10, $dp['nama'], 1, 0, 'L');
                    $pdf->Cell(24, 10, $dp['status'], 1, 0, 'L');
                    $pdf->Cell(44, 10, $dp['keterangan'], 1, 0, 'L');
                    $pdf->Ln();
                }
            }


            $file = 'log5.txt';
            file_put_contents($file, print_r($pdf, true));


            // Close document and sent to the browser 
            $pdf->Output(null, 'presensi-' . time() . '.pdf');
        } elseif ($datum['action'] == 'jadwalbulan') {
            if (isset($datum['id_staff']) && isset($datum['id_kelas']) && isset($datum['bulan'])) {
                header('Content-Type: application/json; charset=utf-8');

                $data = rekap_by_kelas($datum['id_staff'], $datum['id_kelas'], $datum['bulan']);
                echo json_encode($data);
            }
        }
    }
}