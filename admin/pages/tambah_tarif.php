<?php

// session_start();
if (isset($_POST["Simpan"])) {
    $asal = $_POST["asal"];
    $tujuan = $_POST["tujuan"];
    $tarif_perton = $_POST["tarif_perton"];
    $estimasi = $_POST["estimasi"];

    $q = "INSERT INTO tarif VALUES('','$asal','$tujuan','$tarif_perton','$estimasi')";
    mysqli_query($conn, $q);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
                alert('Data Berhasil Disimpan');
                document.location.href='index.php?page=tarif';
            </script>";
    } else {
        echo "<script>
                alert('Data Gagal Disimpan');
                document.location.href='index.php?page=tarif';
            </script>";
    }
}

?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Data Tarif</h1>
    <p class="mb-4">Data ini akan menambahkan data tarif pada sistem ini.</p>

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
                        <label for="asal">Asal</label>
                        <input type="text" class="form-control" id="asal" name="asal">
                    </div>
                    <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <input type="text" class="form-control" id="tujuan" name="tujuan">
                    </div>
                    <div class="form-group">
                        <label for="tarif_perton">Tarif per Ton</label>
                        <input type="text" class="form-control" id="tarif_perton" name="tarif_perton">
                    </div>
                    <div class="form-group">
                        <label for="estimasi">Estimasi</label>
                        <input type="text" class="form-control" id="estimasi" name="estimasi">
                    </div>
                    <button type="submit" class="btn btn-primary" name="Simpan">Simpan</button>
                </form>
            </div>
        </div>
    </div>

</div>