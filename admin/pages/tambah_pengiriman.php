<?php


// Mengambil data dari tabel Client, Driver, Gudang
$clients = $conn->query("SELECT client_id, nama_client, jenis_barang FROM client");
$drivers = $conn->query("SELECT * FROM driver");
$gudangs = $conn->query("SELECT warehouse_id, nama_gudang, alamat_gudang FROM gudang");


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

    // Query untuk menyimpan data pengiriman beserta harga ke database
    $sql = "INSERT INTO Pengiriman (tanggal, client_id, muatan, jenis_barang, target_pengiriman, warehouse_id, tujuan_bongkar, driver_id, harga) 
            VALUES ('$tanggal', '$client_id', '$muatan', '$jenis_barang', '$target_pengiriman', '$warehouse_id', '$tujuan_bongkar', '$driver_id', '$harga')";

    if ($conn->query($sql) === TRUE) {
        // echo json_encode(array("status" => "success", "message" => "Data pengiriman berhasil disimpan."));
        echo "<script>
                alert('Data Berhasil Disimpan');
                document.location.href='index.php?page=pengiriman';
            </script>";
        exit;
    } else {
        // echo json_encode(array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error));
        echo "<script>
                alert('Data Gagal Disimpan');
                document.location.href='index.php?page=pengiriman';
            </script>";
        exit;
    }
}


// Menutup koneksi database
$conn->close();
?>

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
            <option value="<?php echo $row['client_id']; ?>" data-jenis="<?php echo $row['jenis_barang']; ?>">
                <?php echo $row['nama_client']; ?></option>
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
            <option value="<?php echo $row['warehouse_id']; ?>" data-alamat="<?php echo $row['alamat_gudang']; ?>">
                <?php echo $row['nama_gudang']; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="alamat_gudang">Alamat Gudang:</label>
        <input type="text" class="form-control" id="alamat_gudang" name="alamat_gudang" readonly>
    </div>

    <div class="form-group">
        <label for="tujuan_bongkar">Tujuan Bongkar:</label>
        <select class="form-control" id="tujuan_bongkar" name="tujuan_bongkar" required>
            <option value="">Pilih Tujuan Bongkar</option>
            <?php while ($tarif_row = $tarifs->fetch_assoc()) { ?>
            <option value="<?php echo $tarif_row['tujuan']; ?>"
                data-alamat="<?php echo $tarif_row['alamat_gudang']; ?>">
                <?php echo $tarif_row['tujuan']; ?>
            </option>
            <?php } ?>
        </select>
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
        <label for="harga">Harga:</label>
        <input type="text" class="form-control" id="harga" name="harga">
        <!-- Tambahkan input tersembunyi untuk menyimpan harga -->
        <input type="hidden" id="harga_hidden" name="harga_hidden">
    </div>



    <!-- Sisanya form Anda tetap seperti sebelumnya -->

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script src="../../js/jquery.min.js"></script>
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