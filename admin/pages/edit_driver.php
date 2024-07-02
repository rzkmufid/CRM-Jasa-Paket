<?php

// session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM driver WHERE driver_id =$id");
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $nama_supir = $_POST['nama_supir'];
    $alamat = $_POST['alamat'];
    $plat = $_POST['plat'];

    mysqli_query($conn, "UPDATE driver SET nama_supir='$nama_supir', alamat='$alamat', plat='$plat' WHERE driver_id=$id");
    echo
    "<script>window.location.href = 'index.php?page=driver';</script>";
    // header("Location: ../index.php");
}


?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Data Driver</h1>
    <p class="mb-4">Data yang diubah akan dimasukkan ke data Driver pada sistem ini.</p>

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
                        <label for="nama_supir">Nama Driver:</label>
                        <input type="text" class="form-control" id="nama_supir" name="nama_supir" value="<?php echo $row['nama_supir']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Client</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="plat">PLAT</label>
                        <input type="text" class="form-control" id="plat" name="plat" value="<?php echo $row['plat']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="update">Simpan</button>
                </form>
            </div>
        </div>
    </div>

</div>