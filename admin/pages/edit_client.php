<?php
// session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM client WHERE client_id=$id");
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $nama_client = $_POST['nama_client'];
    $jenis_barang = $_POST['jenis_barang'];

    mysqli_query($conn, "UPDATE client SET nama_client='$nama_client', jenis_barang='$jenis_barang' WHERE client_id=$id");
    //     header("Location: index.php?page=client");
    echo "<script>window.location.href = 'index.php?page=client';</script>";
    // header("Location: index.php");
}

?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Data Client</h1>
    <p class="mb-4">Data yang diedit akan dimasukkan ke data client pada sistem ini.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Client</h6>
        </div>
        <div class="card-body">
            <!-- <h1>Test</h1> -->
            <div class="p-4">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nama_client">Nama Client:</label>
                        <input type="text" class="form-control" id="nama_client" name="nama_client" value="<?php echo $row['nama_client']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="jenis_barang">Jenis Barang</label>
                        <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" value="<?php echo $row['jenis_barang']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="update">Simpan</button>
                </form>
            </div>
        </div>
    </div>

</div>