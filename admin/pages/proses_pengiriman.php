<?php


// Mendapatkan ID pengiriman dari URL
$id_pengiriman = $_GET['id'];

// Mengambil data pengiriman berdasarkan ID
$sql = "SELECT * FROM Pengiriman WHERE pengiriman_id = $id_pengiriman";
$result = $conn->query($sql);
$pengiriman = $result->fetch_assoc();

if (!$pengiriman) {
    die("Data pengiriman tidak ditemukan.");
}

// Mengambil data client
$client_sql = "SELECT client_id, nama_client, jenis_barang FROM client WHERE client_id = " . $pengiriman['client_id'];
$client_result = $conn->query($client_sql);
$client = $client_result->fetch_assoc();

// Mengambil data gudang
$warehouse_sql = "SELECT warehouse_id, nama_gudang, alamat_gudang FROM gudang WHERE warehouse_id = " . $pengiriman['warehouse_id'];
$warehouse_result = $conn->query($warehouse_sql);
$warehouse = $warehouse_result->fetch_assoc();

// Mengambil data driver
$driver_sql = "SELECT * FROM driver WHERE driver_id = " . $pengiriman['driver_id'];
$driver_result = $conn->query($driver_sql);
$driver = $driver_result->fetch_assoc();

// Logika untuk memperbarui data pengiriman
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $realisasi_pengiriman = $_POST['realisasi_pengiriman'];
    $tanggal_bongkar = $_POST['tanggal_bongkar'];
    $keterlambatan = $_POST['keterlambatan'];

    $update_sql = "UPDATE Pengiriman SET 
                    realisasi_pengiriman = '$realisasi_pengiriman', 
                    tanggal_bongkar = '$tanggal_bongkar', 
                    keterlambatan = '$keterlambatan' 
                   WHERE pengiriman_id = $id_pengiriman";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Data pengiriman berhasil diperbarui.'); window.location.href='index.php?page=pengiriman&id=$id_pengiriman';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Menutup koneksi database
$conn->close();
?>

<h2>Detail Pengiriman</h2>
<table class="table table-bordered">
    <tr>
        <th>Tanggal</th>
        <td><?php echo $pengiriman['tanggal']; ?></td>
    </tr>
    <tr>
        <th>Client</th>
        <td><?php echo $client['nama_client']; ?></td>
    </tr>
    <tr>
        <th>Jenis Barang</th>
        <td><?php echo $client['jenis_barang']; ?></td>
    </tr>
    <tr>
        <th>Muatan (ton)</th>
        <td><?php echo $pengiriman['muatan']; ?></td>
    </tr>
    <tr>
        <th>Target Pengiriman (Hari)</th>
        <td><?php echo $pengiriman['target_pengiriman']; ?></td>
    </tr>
    <tr>
        <th>Asal Gudang</th>
        <td><?php echo $warehouse['nama_gudang']; ?></td>
    </tr>
    <tr>
        <th>Alamat Gudang</th>
        <td><?php echo $warehouse['alamat_gudang']; ?></td>
    </tr>
    <tr>
        <th>Tujuan Bongkar</th>
        <td><?php echo $pengiriman['tujuan_bongkar']; ?></td>
    </tr>
    <tr>
        <th>Driver</th>
        <td><?php echo $driver['nama_supir']; ?></td>
    </tr>
    <tr>
        <th>Realisasi Pengiriman (Hari)</th>
        <td><?php echo $pengiriman['realisasi_pengiriman']; ?></td>
    </tr>
    <tr>
        <th>Tanggal Bongkar</th>
        <td><?php echo $pengiriman['tanggal_bongkar']; ?></td>
    </tr>
    <tr>
        <th>Keterlambatan (Hari)</th>
        <td><?php echo $pengiriman['keterlambatan']; ?></td>
    </tr>
    <tr>
        <th>Harga</th>
        <td><?php echo $pengiriman['harga']; ?></td>
    </tr>
</table>

<h3>Update Data Pengiriman</h3>
<form method="post" action="">
    <div class="form-group">
        <label for="realisasi_pengiriman">Realisasi Pengiriman (Hari):</label>
        <input type="number" class="form-control" id="realisasi_pengiriman" name="realisasi_pengiriman" required>
    </div>
    <div class="form-group">
        <label for="tanggal_bongkar">Tanggal Bongkar:</label>
        <input type="date" class="form-control" id="tanggal_bongkar" name="tanggal_bongkar" required>
    </div>
    <div class="form-group">
        <label for="keterlambatan">Keterlambatan (Hari):</label>
        <input type="number" class="form-control" id="keterlambatan" name="keterlambatan" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>