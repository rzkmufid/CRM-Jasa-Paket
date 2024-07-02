<?php

if (isset($_POST["Simpan"])) {
    $nama_gudang = $_POST["nama_gudang"];
    $alamat_gudang = $_POST["alamat_gudang"];

    $q = "INSERT INTO gudang (nama_gudang, alamat_gudang) VALUES('$nama_gudang', '$alamat_gudang')";
    mysqli_query($conn, $q);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
                alert('Data Berhasil Disimpan');
                document.location.href='index.php?page=gudang';
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Disimpan');
                document.location.href='index.php';
            </script>";
    }
}


$row = $result->fetch_assoc();

?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Data Gudang</h1>
    <p class="mb-4">Data ini akan mengeluarkan data gudang yang terdaftar pada sistem ini.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Gudang</h6>
        </div>
        <div class="card-body">
            <div class="p-4">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nama_gudang">Nama Gudang:</label>
                        <input type="text" class="form-control" id="nama_gudang" name="nama_gudang" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_gudang">Alamat Gudang:</label>
                        <textarea class="form-control" id="alamat_gudang" name="alamat_gudang" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="Simpan">Simpan</button>
                </form>
            </div>
        </div>
    </div>

</div>