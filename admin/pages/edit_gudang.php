<?php

// session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM gudang WHERE warehouse_id = $id");
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $nama_gudang = $_POST['nama_gudang'];
    $alamat_gudang = $_POST['alamat_gudang'];

    mysqli_query($conn, "UPDATE gudang SET nama_gudang='$nama_gudang', alamat_gudang='$alamat_gudang' WHERE warehouse_id=$id");
    // header("Location: gudang.php");
    echo "<script>window.location.href = 'index.php?page=gudang';</script>";
}

?>


<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Data Gudang</h1>
    <p class="mb-4">Edit Data Gudang Yang Tersedia</p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Gudang</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Nama Gudang</label>
                    <input type="text" name="nama_gudang" class="form-control" value="<?php echo $row['nama_gudang']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Alamat Gudang</label>
                    <textarea name="alamat_gudang" class="form-control" required><?php echo $row['alamat_gudang']; ?></textarea>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>