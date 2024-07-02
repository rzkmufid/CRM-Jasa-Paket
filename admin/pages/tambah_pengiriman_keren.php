<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shipment_management";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari tabel Client, Driver, Gudang
$clients = $conn->query("SELECT client_id, nama_client, jenis_barang FROM client");
$drivers = $conn->query("SELECT * FROM driver");
$gudangs = $conn->query("SELECT warehouse_id, nama_gudang, alamat_gudang FROM gudang");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menyimpan data pengiriman
    $tanggal = $_POST['tanggal'];
    $client_id = $_POST['client_id'];
    $muatan = $_POST['muatan'];
    $jenis_barang = $_POST['jenis_barang'];
    $target_pengiriman = $_POST['target_pengiriman'];
    $warehouse_id = $_POST['warehouse_id'];
    $tujuan_bongkar = $_POST['tujuan_bongkar'];
    $driver_id = $_POST['driver_id'];
    $realisasi_pengiriman = $_POST['realisasi_pengiriman'];
    $tanggal_bongkar = $_POST['tanggal_bongkar'];
    $keterlambatan = $_POST['keterlambatan'];
    $harga = $_POST['harga']; // Ambil nilai harga dari input form

    // Ambil alamat gudang berdasarkan warehouse_id yang dipilih
    $alamat_gudang = "";
    $result = $conn->query("SELECT alamat_gudang FROM gudang WHERE warehouse_id = '$warehouse_id'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $alamat_gudang = $row['alamat_gudang'];
    }

    // Query untuk menyimpan data pengiriman beserta harga ke database
    $sql = "INSERT INTO Pengiriman (tanggal, client_id, muatan, jenis_barang, target_pengiriman, warehouse_id, tujuan_bongkar, driver_id, realisasi_pengiriman, tanggal_bongkar, keterlambatan, harga) 
            VALUES ('$tanggal', '$client_id', '$muatan', '$jenis_barang', '$target_pengiriman', '$warehouse_id', '$tujuan_bongkar', '$driver_id', '$realisasi_pengiriman', '$tanggal_bongkar', '$keterlambatan', '$harga')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "Data pengiriman berhasil disimpan."));
        exit;
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error));
        exit;
    }
}

// Menutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Pengiriman</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Tambah Pengiriman</h2>
        <form id="formTambahPengiriman" method="post" action="">
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>

            <div class="form-group">
                <label for="client_id">Client:</label>
                <select class="form-control" id="client_id" name="client_id" required>
                    <option value="">Pilih Client</option>
                    <?php while ($row = $clients->fetch_assoc()) { ?>
                        <option value="<?php echo $row['client_id']; ?>" data-jenis="<?php echo $row['jenis_barang']; ?>"><?php echo $row['nama_client']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jenis_barang">Jenis Barang:</label>
                <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" readonly required>
            </div>

            <div class="form-group">
                <label for="muatan">Muatan (ton):</label>
                <input type="number" class="form-control" step="0.01" id="muatan" name="muatan" required>
            </div>

            <div class="form-group">
                <label for="target_pengiriman">Target Pengiriman (Hari):</label>
                <input type="number" class="form-control" id="target_pengiriman" name="target_pengiriman" required>
            </div>

            <div class="form-group">
                <label for="warehouse_id">Asal Gudang:</label>
                <select class="form-control" id="warehouse_id" name="warehouse_id" required>
                    <option value="">Pilih Gudang</option>
                    <?php while ($row = $gudangs->fetch_assoc()) { ?>
                        <option value="<?php echo $row['warehouse_id']; ?>" data-alamat="<?php echo $row['alamat_gudang']; ?>"><?php echo $row['nama_gudang']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat_gudang">Alamat Gudang:</label>
                <input type="text" class="form-control" id="alamat_gudang" name="alamat_gudang" readonly>
            </div>

            <div class="form-group">
                <label for="tujuan_bongkar">Tujuan Bongkar:</label>
                <input type="text" class="form-control" id="tujuan_bongkar" name="tujuan_bongkar" required>
            </div>

            <div class="form-group">
                <label for="driver_id">Driver:</label>
                <select class="form-control" id="driver_id" name="driver_id" required>
                    <option value="">Pilih Driver</option>
                    <?php while ($row = $drivers->fetch_assoc()) { ?>
                        <option value="<?php echo $row['driver_id']; ?>"><?php echo $row['nama_supir']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="realisasi_pengiriman">Realisasi Pengiriman (Hari):</label>
                <input type="number" class="form-control" id="realisasi_pengiriman" name="realisasi_pengiriman">
            </div>

            <div class="form-group">
                <label for="tanggal_bongkar">Tanggal Bongkar:</label>
                <input type="date" class="form-control" id="tanggal_bongkar" name="tanggal_bongkar">
            </div>

            <div class="form-group">
                <label for="keterlambatan">Keterlambatan (hari):</label>
                <input type="number" class="form-control" id="keterlambatan" name="keterlambatan">
            </div>

            <div class="form-group">
                <label for="harga">Harga (Otomatis):</label>
                <input type="text" class="form-control" id="harga" name="harga" readonly>
            </div>
            <!-- Sisanya form Anda tetap seperti sebelumnya -->

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // JavaScript untuk mengisi jenis barang otomatis berdasarkan client yang dipilih
        $(document).ready(function() {
            $('#client_id').change(function() {
                var selectedClient = $(this).find(':selected');
                var jenisBarang = selectedClient.attr('data-jenis');
                $('#jenis_barang').val(jenisBarang);
            });

            // JavaScript untuk mengisi alamat gudang otomatis berdasarkan gudang yang dipilih
            $('#warehouse_id').change(function() {
                var selectedWarehouse = $(this).find(':selected');
                var alamatGudang = selectedWarehouse.attr('data-alamat');
                $('#alamat_gudang').val(alamatGudang);
            });

            // Submit form menggunakan AJAX
            $('#formTambahPengiriman').submit(function(e) {
                e.preventDefault(); // Menghentikan pengiriman form biasa
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            // Reset form setelah berhasil disimpan
                            form.trigger('reset');
                            $('#jenis_barang').val('');
                            $('#alamat_gudang').val('');
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error); // Debugging error jika ada
                        alert("Terjadi kesalahan saat menyimpan data.");
                    }
                });
            });
        });
    </script>
</body>

</html>