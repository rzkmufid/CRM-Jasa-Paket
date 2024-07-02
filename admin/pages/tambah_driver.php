<?php
// session_start();
if (isset($_POST["Simpan"])) {
    $nama_supir = $_POST["nama_supir"];
    $alamat = $_POST["alamat"];
    $plat = $_POST["plat"];

    $q = "INSERT INTO driver VALUES('','$nama_supir','$alamat', '$plat')";
    mysqli_query($conn, $q);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
                alert('Data Berhasil Disimpan');
                document.location.href='index.php?page=driver';
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Disimpan');
                document.location.href='index.php?page=driver';
            </script>";
    }
}

?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Data Driver</h1>
    <p class="mb-4">Data ini akan mengeluarkan data driver yang terdaftar pada sistem ini.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Driver</h6>
        </div>
        <div class="card-body">
            <!-- <h1>Test</h1> -->
            <div class="p-4">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nama_driver">Nama Driver</label>
                        <input type="text" class="form-control" id="nama_supir" name="nama_supir">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat driver</label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="form-group">
                        <label for="plat">Plat</label>
                        <input type="plat" class="form-control" id="plat" name="plat">
                    </div>
                    <button type="submit" class="btn btn-primary" name="Simpan">Simpan</button>
                </form>
            </div>
        </div>
    </div>

</div>