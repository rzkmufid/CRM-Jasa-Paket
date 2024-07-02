<?php

// session_start();
if (isset($_POST["Simpan"])) {
    $nama_client = $_POST["nama_client"];
    $jenis_barang = $_POST["jenis_barang"];

    $q = "INSERT INTO client VALUES('','$nama_client','$jenis_barang')";
    mysqli_query($conn, $q);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
                alert('Data Berhasil Disimpan');
                document.location.href='index.php?page=client';
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Disimpan');
                document.location.href='index.php?page=client';
            </script>";
    }
}
?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Data Client</h1>
    <p class="mb-4">Data ini akan mengeluarkan data client yang terdaftar pada sistem ini.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Client</h6>
        </div>
        <div class="card-body">
            <!-- <h1>Test</h1> -->
            <div class="p-4">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nama_client">Nama Client:</label>
                        <input type="text" class="form-control" id="nama_client" name="nama_client">
                    </div>
                    <div class="form-group">
                        <label for="jenis_barang">Jenis Barang</label>
                        <input type="text" class="form-control" id="jenis_barang" name="jenis_barang">
                    </div>
                    <button type="submit" class="btn btn-primary" name="Simpan">Simpan</button>
                </form>
            </div>
        </div>
    </div>

</div>