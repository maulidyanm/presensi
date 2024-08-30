<?php
session_start();
$duplicateError = isset($_SESSION['duplicateError']) ? $_SESSION['duplicateError'] : false;
unset($_SESSION['duplicateError']); // Clear the error after use
?>
<style>
.is-invalid {
    border-color: red !important;
    position: relative;
}

.is-invalid::after {
    content: '!';
    color: red;
    font-weight: bold;
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    font-size: 1.2em;
}

.invalid-feedback {
    color: red !important;
    font-size: 0.9em;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all input elements
    var inputs = document.querySelectorAll('input');

    // Add event listener to each input
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            if (input.classList.contains('is-invalid')) {
                input.classList.remove('is-invalid');
                var feedback = input.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.style.display = 'none';
                }
            }
        });
    });
});
</script>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title" style="color: white;">Guru</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="main.php">
                    <i class="flaticon-home" style="color: white;"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a href="#" style="color: white;">Data Guru</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow" style="color: white;"></i>
            </li>
            <li class="nav-item">
                <a href="#" style="color: white;">Tambah Guru</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card" style="background-color: rgba(36, 36, 44, 0.9);">
                <div class="card-header d-flex align-items-center">
                    <h3 class="h4" style="color: white !important;">Tambah Guru</h3>
                </div>
                <div class="card-body">
                    <form action="?page=guru&act=proses" method="post" enctype="multipart/form-data">
                        <table cellpadding="3" style="font-weight: bold; width: 100%;">
                            <tr>
                                <td style="color: white !important; width: 30%;">Kode Guru</td>
                                <td style="color: white; width: 5%;">:</td>
                                <td style="width: 65%;">
                                    <input id="nip" name="nip" type="text"
                                        class="form-control <?= $duplicateError ? 'is-invalid' : '' ?>"
                                        placeholder="Kode Guru" required
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white; width: 100%;">
                                    <?php if ($duplicateError): ?>
                                    <div class="invalid-feedback">
                                        Kode Guru sudah ada.
                                    </div>
                                    <?php endif; ?>
                                    <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var inputNIP = document.getElementById('nip');

                                        // Add event listener to input field
                                        inputNIP.addEventListener('input', function() {
                                            var currentValue = inputNIP.value;
                                            var uppercaseValue = currentValue
                                                .toUpperCase(); // Convert to uppercase

                                            if (currentValue !== uppercaseValue) {
                                                // If the value is not in all caps, update the input value
                                                inputNIP.value = uppercaseValue;
                                            }
                                        });
                                    });
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white !important;">Nama Guru</td>
                                <td style="color: white; width: 5%;">:</td>
                                <td>
                                    <input id="nama" name="nama" type="text" class="form-control"
                                        placeholder="Nama dan Gelar" required
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white; width: 100%;">
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white !important;">Email</td>
                                <td style="color: white; width: 5%;">:</td>
                                <td>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Email"
                                        required
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white; width: 100%;">
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white !important;">Pas Foto</td>
                                <td style="color: white; width: 5%;">:</td>
                                <td>
                                    <input type="file" class="form-control" name="foto" required
                                        style="background-color: rgba(36, 36, 44, 0.9); color: white; width: 100%;">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">
                                    <button name="saveGuru" type="submit" class="btn btn-primary"><i
                                            class="fa fa-save"></i> Simpan
                                    </button>
                                    <a href="javascript:history.back()" class="btn btn-warning"><i
                                            class="fa fa-chevron-left"></i> Batal</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>