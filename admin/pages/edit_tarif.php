<?php

// session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM tarif WHERE id_tarif = $id");
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $asal = $_POST['asal'];
    $tujuan = $_POST['tujuan'];
    $tarif_perton = $_POST['tarif_perton'];
    $estimasi = $_POST['estimasi'];

    mysqli_query($conn, "UPDATE tarif SET asal='$asal', tujuan='$tujuan', tarif_perton='$tarif_perton', estimasi='$estimasi' WHERE id_tarif =$id");
    // header("Location: gudang.php");
    echo "<script>window.location.href = 'index.php?page=tarif';</script>";
}

?>


<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Data Tarif</h1>
    <p class="mb-4">Edit Data Tarif Yang Tersedia</p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Tarif</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Asal</label>
                    <input type="text" name="asal" class="form-control" value="<?php echo $row['asal']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Tujuan</label>
                    <textarea name="tujuan" class="form-control" required><?php echo $row['tujuan']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Tarif Perton (ton)</label>
                    <textarea name="tarif_perton" class="form-control" required><?php echo $row['tarif_perton']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Estimasi</label>
                    <textarea name="estimasi" class="form-control" required><?php echo $row['estimasi']; ?></textarea>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>