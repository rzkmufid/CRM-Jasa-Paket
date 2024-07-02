<?php

$id = $_GET['id'];

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM pengiriman WHERE pengiriman_id = $id");
    $row = $result->fetch_assoc();
} else {
    echo "ID pengiriman tidak ditemukan.";
    exit;
}

// Memeriksa apakah form Estimasi, Tanggal Bongkar, dan Keterlambatan perlu ditampilkan
$realisasi_pengiriman = $row['realisasi_pengiriman'];
$tanggal_bongkar = $row['tanggal_bongkar'];
$keterlambatan = $row['keterlambatan'];
$gudangid = $row['warehouse_id'];

$show_form_realisasi = !is_null($realisasi_pengiriman);
$show_form_tanggal_bongkar = !is_null($tanggal_bongkar);
$show_form_keterlambatan = !is_null($keterlambatan);

// Mengambil data dari tabel Client, Driver, Gudang
$clients = $conn->query("SELECT client_id, nama_client, jenis_barang FROM client");
$drivers = $conn->query("SELECT * FROM driver");
$gudangs = $conn->query("SELECT warehouse_id, nama_gudang, alamat_gudang FROM gudang");
$queryalamatGudang = $conn->query("SELECT warehouse_id, nama_gudang, alamat_gudang FROM gudang WHERE warehouse_id = '$gudangid'");
$alamatGudang = $queryalamatGudang->fetch_assoc();
// echo alamatGudang;

// Query untuk mengambil tarif gabungan
$tarif_query = "
    SELECT t1.asal, t1.tujuan, t1.tarif_perton, g.alamat_gudang
    FROM (
        SELECT asal, tujuan, tarif_perton
        FROM tarif
        UNION
        SELECT tujuan AS asal, asal AS tujuan, tarif_perton
        FROM tarif
    ) AS t1
    JOIN gudang g ON t1.asal = g.alamat_gudang;
";
$tarifs = $conn->query($tarif_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $tanggal = $_POST['tanggal'];
    $client_id = $_POST['client_id'];
    $muatan = $_POST['muatan'];
    $jenis_barang = $_POST['jenis_barang'];
    $target_pengiriman = $_POST['target_pengiriman'];
    $warehouse_id = $_POST['warehouse_id'];
    $tujuan_bongkar = $_POST['tujuan_bongkar'];
    $driver_id = $_POST['driver_id'];
    $harga = $_POST['harga_hidden']; // Ambil nilai harga dari input tersembunyi

    // Query untuk mengupdate data pengiriman kecuali alamat_gudang
    $sql = "UPDATE pengiriman 
            SET tanggal='$tanggal', client_id='$client_id', muatan='$muatan', jenis_barang='$jenis_barang', target_pengiriman='$target_pengiriman', warehouse_id='$warehouse_id', tujuan_bongkar='$tujuan_bongkar', driver_id='$driver_id', harga='$harga'
            WHERE pengiriman_id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Data Berhasil Diperbarui');
                document.location.href='index.php?page=pengiriman';
            </script>";
        exit;
    } else {
        echo "<script>
                alert('Data Gagal Diperbarui');
                document.location.href='index.php?page=pengiriman';
            </script>";
        exit;
    }
}

// Menutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Pengiriman</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Pengiriman</h2>
        <form id="formEditPengiriman" method="post" action="">
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>" required>
            </div>

            <div class="form-group">
                <label for="client_id">Client:</label>
                <select class="form-control" id="client_id" name="client_id" required>
                    <option value="">Pilih Client</option>
                    <?php while ($client_row = $clients->fetch_assoc()) { ?>
                        <option value="<?php echo $client_row['client_id']; ?>" <?php if ($client_row['client_id'] == $row['client_id']) echo 'selected'; ?> data-jenis="<?php echo $client_row['jenis_barang']; ?>">
                            <?php echo $client_row['nama_client']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jenis_barang">Jenis Barang:</label>
                <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" value="<?php echo $row['jenis_barang']; ?>" readonly required>
            </div>

            <div class="form-group">
                <label for="muatan">Muatan (ton):</label>
                <input type="number" class="form-control" step="0.01" id="muatan" name="muatan" value="<?php echo $row['muatan']; ?>" required>
            </div>

            <div class="form-group">
                <label for="target_pengiriman">Target Pengiriman (Hari):</label>
                <input type="number" class="form-control" id="target_pengiriman" name="target_pengiriman" value="<?php echo $row['target_pengiriman']; ?>" required>
            </div>

            <div class="form-group">
                <label for="warehouse_id">Asal Gudang:</label>
                <select class="form-control" id="warehouse_id" name="warehouse_id" required>
                    <option value="">Pilih Gudang</option>
                    <?php while ($gudang_row = $gudangs->fetch_assoc()) { ?>
                        <option value="<?php echo $gudang_row['warehouse_id']; ?>" <?php if ($gudang_row['warehouse_id'] == $row['warehouse_id']) echo 'selected'; ?> data-alamat="<?php echo $gudang_row['alamat_gudang']; ?>">
                            <?php echo $gudang_row['nama_gudang']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat_gudang">Alamat Gudang:</label>
                <input type="text" class="form-control" id="alamat_gudang" name="alamat_gudang" value="<?= $alamatGudang['alamat_gudang'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="tujuan_bongkar">Tujuan Bongkar:</label>
                <select class="form-control" id="tujuan_bongkar" name="tujuan_bongkar" required>
                    <option value="">Pilih Tujuan Bongkar</option>
                    <?php while ($tarif_row = $tarifs->fetch_assoc()) { ?>
                        <option value="<?php echo $tarif_row['tujuan']; ?>" <?php if ($tarif_row['tujuan'] == $row['tujuan_bongkar']) echo 'selected'; ?>>
                            <?php echo $tarif_row['tujuan']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="driver_id">Driver:</label>
                <select class="form-control" id="driver_id" name="driver_id">
                    <option value="">Pilih Driver</option>
                    <?php while ($driver_row = $drivers->fetch_assoc()) { ?>
                        <option value="<?php echo $driver_row['driver_id']; ?>" <?php if ($driver_row['driver_id'] == $row['driver_id']) echo 'selected'; ?>>
                            <?php echo $driver_row['nama_supir']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <?php if ($show_form_realisasi) : ?>
                <div class="form-group">
                    <label for="realisasi_pengiriman">Realisasi Pengiriman:</label>
                    <input type="text" class="form-control" id="realisasi_pengiriman" name="realisasi_pengiriman" value="<?= $realisasi_pengiriman ?>" required>
                </div>
            <?php endif; ?>

            <?php if ($show_form_tanggal_bongkar) : ?>
                <div class="form-group">
                    <label for="tanggal_bongkar">Tanggal Bongkar:</label>
                    <input type="date" class="form-control" id="tanggal_bongkar" name="tanggal_bongkar" value="<?= $tanggal_bongkar ?>" required>
                </div>
            <?php endif; ?>

            <?php if ($show_form_keterlambatan) : ?>
                <div class="form-group">
                    <label for="keterlambatan">Keterlambatan:</label>
                    <input type="text" class="form-control" id="keterlambatan" name="keterlambatan" value="<?= $keterlambatan ?>" required>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="text" class="form-control" id="harga" name="harga" value="<?= $row['harga']; ?>" required readonly>
            </div>

            <input type="hidden" name="harga_hidden" id="harga_hidden" value="<?= $row['harga']; ?>">

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

                // AJAX untuk mengisi pilihan tujuan bongkar berdasarkan gudang yang dipilih
                $.ajax({
                    url: 'getTujuan.php', // Ubah sesuai dengan endpoint yang sesuai
                    method: 'GET',
                    data: {
                        alamat_gudang: alamatGudang
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#tujuan_bongkar').empty();
                        $('#tujuan_bongkar').append($('<option>', {
                            value: '',
                            text: 'Pilih Tujuan Bongkar'
                        }));
                        response.forEach(function(item) {
                            $('#tujuan_bongkar').append($('<option>', {
                                value: item.tujuan,
                                text: item.tujuan
                            }));
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error); // Debugging error jika ada
                        alert("Terjadi kesalahan saat mengambil data tujuan bongkar.");
                    }
                });
            });

            // Ketika data gudang dan tujuan bongkar dipilih, hitung harga
            $('#tujuan_bongkar').change(function() {
                var alamatGudang = $('#warehouse_id').find(':selected').attr('data-alamat');
                var tujuanBongkar = $('#tujuan_bongkar').val();
                var muatan = document.querySelector('[name="muatan"]').value;

                // Lakukan AJAX untuk mengambil harga dari server
                $.ajax({
                    url: 'getHarga.php', // Ganti dengan endpoint yang sesuai
                    method: 'POST',
                    data: {
                        alamat_gudang: alamatGudang,
                        tujuan_bongkar: tujuanBongkar,
                        muatan: muatan
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            var harga = response.harga;
                            $('#harga').val(harga);
                            $('#harga_hidden').val(harga);
                        } else {
                            console.error("Error:", response.message);
                            alert("Gagal mengambil harga.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        alert("Silahkan Masukkan Berat Muatan.");
                    }
                });
            });
        });
    </script>


</body>

</html>