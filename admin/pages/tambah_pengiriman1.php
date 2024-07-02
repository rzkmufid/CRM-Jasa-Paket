<?php
if (isset($_POST['simpan'])) {
    // Ambil data dari form
    $client_id = $_POST['client_id'];
    $nama_supir = $_POST['nama_supir'];
    $asal_gudang = $_POST['asal_gudang'];
    $tanggal_muat = $_POST['tanggal_muat'];
    $tanggal_bongkar = $_POST['tanggal_bongkar'];
    $jenis_barang = $_POST['jenis_barang'];
    $target_pengiriman = $_POST['target_pengiriman'];
    $tujuan_bongkar = $_POST['tujuan_bongkar'];
    $plat = $_POST['plat'];
    $realisasi_pengiriman = $_POST['realisasi_pengiriman'];
    $keterlambatan = $_POST['keterlambatan'];
    $status_pengiriman = $_POST['status_pengiriman'];

    // Query untuk memasukkan data ke dalam tabel pengiriman
    $insert_query = "INSERT INTO pengiriman (client_id, driver_id, asal_gudang_id, tanggal_muat, tanggal_bongkar, jenis_barang, target_pengiriman, tujuan_bongkar, plat, realisasi_pengiriman, keterlambatan, status_pengiriman)
                    VALUES ('$client_id', '$nama_supir', '$asal_gudang', '$tanggal_muat', '$tanggal_bongkar', '$jenis_barang', '$target_pengiriman', '$tujuan_bongkar', '$plat', '$realisasi_pengiriman', '$keterlambatan', '$status_pengiriman')";

    // Eksekusi query
    if (mysqli_query($conn, $insert_query)) {
        echo "<script>
                alert('Data Berhasil Disimpan');
                document.location.href='index.php?page=pengiriman';
            </script>";
        exit();
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
    }
}


$user_id = $_SESSION['user_id'];
$sql = "SELECT first_name, last_name FROM users WHERE id = '$user_id' LIMIT 1";
$result1 = $conn->query($sql);

$row1 = $result1->fetch_assoc();
?>



<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Data Client</h1>
    <p class="mb-4">Data yang diinputkan akan dimasukkan ke data client pada sistem ini.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Client</h6>
        </div>
        <div class="card-body">
            <!-- <h1>Test</h1> -->
            <form class="" action="" method="post">
                <div class="form-group">
                    <label for="client_id">Nama Client:</label>
                    <select class="form-control" id="client_id" name="client_id">
                        <?php
                        $client_result = mysqli_query($conn, "SELECT * FROM client");
                        while ($client_row = mysqli_fetch_assoc($client_result)) {
                            echo "<option value=\"" . $client_row['client_id'] . "\">" . $client_row['nama_client'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nama_supir">Nama Supir:</label>
                    <select class="form-control" id="nama_supir" name="nama_supir">
                        <?php
                        $driver_result = mysqli_query($conn, "SELECT * FROM driver");
                        while ($driver_row = mysqli_fetch_assoc($driver_result)) {
                            echo "<option value=\"" . $driver_row['driver_id'] . "\">" . $driver_row['nama_supir'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="asal_gudang">Asal Gudang:</label>
                    <select class="form-control" id="asal_gudang" name="asal_gudang">
                        <?php
                        $gudang_result = mysqli_query($conn, "SELECT * FROM gudang");
                        while ($gudang_row = mysqli_fetch_assoc($gudang_result)) {
                            echo "<option value=\"" . $gudang_row['warehouse_id'] . "\">" . $gudang_row['nama_gudang'] . "</option>";
                        }
                        ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="tanggal_muat">Tanggal Muat:</label>
                    <input type="date" class="form-control" id="tanggal_muat" name="tanggal_muat">
                </div>

                <div class="form-group">
                    <label for="tanggal_bongkar">Tanggal Bongkar:</label>
                    <input type="date" class="form-control" id="tanggal_bongkar" name="tanggal_bongkar">
                </div>

                <div class="form-group">
                    <label for="jenis_barang">Jenis Barang:</label>
                    <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" value="ESTA KIESER-MAG">
                </div>

                <div class="form-group">
                    <label for="target_pengiriman">Target Pengiriman:</label>
                    <input type="text" class="form-control" id="target_pengiriman" name="target_pengiriman">
                </div>

                <div class="form-group">
                    <label for="tujuan_bongkar">Tujuan Bongkar:</label>
                    <input type="text" class="form-control" id="tujuan_bongkar" name="tujuan_bongkar" value="CIPTA FUTURA ESTATE">
                </div>

                <div class="form-group">
                    <label for="plat">Plat:</label>
                    <input type="text" class="form-control" id="plat" name="plat">
                </div>

                <div class="form-group">
                    <label for="realisasi_pengiriman">Realisasi Pengiriman:</label>
                    <input type="text" class="form-control" id="realisasi_pengiriman" name="realisasi_pengiriman">
                </div>

                <div class="form-group">
                    <label for="keterlambatan">Keterlambatan:</label>
                    <input type="text" class="form-control" id="keterlambatan" name="keterlambatan">
                </div>

                <div class="form-group">
                    <label for="status_pengiriman">Status:</label>
                    <select class="form-control" id="status_pengiriman" name="status_pengiriman">
                        <option value="Belum Berangkat">Belum Berangkat</option>
                        <option value="Dalam Perjalanan">Dalam Perjalanan</option>
                        <option value="Telah Sampai">Telah Sampai</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
            </form>

        </div>
    </div>

</div>