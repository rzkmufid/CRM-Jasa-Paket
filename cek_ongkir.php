<h2 class="mb-4">Cek Ongkir</h2>

<!-- Form untuk memasukkan asal dan tujuan pengiriman -->
<form method="get" action="index.php">
    <input type="text" name="page" value="cek_ongkir" hidden>

    <div class="form-group">
        <label for="asal">Kota Asal:</label>
        <select class="form-control" id="asal" name="asal" required>
            <option value="">Pilih Kota Asal</option>
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root"; // Ganti dengan username database Anda
            $password = ""; // Ganti dengan password database Anda
            $dbname = "shipment_management"; // Ganti dengan nama database Anda

            // Membuat koneksi
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Memeriksa koneksi
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Query untuk mendapatkan daftar kota asal dan tujuan beserta tarif/ton
            $query = "SELECT DISTINCT asal FROM (
                        SELECT asal, tujuan FROM tarif
                        UNION
                        SELECT tujuan AS asal, asal AS tujuan FROM tarif
                    ) AS t1";

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['asal'] . "'>" . $row['asal'] . "</option>";
                }
            }

            // Tutup koneksi database
            $conn->close();
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="tujuan">Kota Tujuan:</label>
        <select class="form-control" id="tujuan" name="tujuan" required>
            <option value="">Pilih Kota Tujuan</option>
        </select>
    </div>
    <div class="form-group">
        <label for="muatan">Muatan (ton):</label>
        <input type="number" step="0.01" class="form-control" id="muatan" name="muatan" placeholder="Muatan dalam ton" required>
    </div>
    <button type="submit" class="btn btn-primary">Cek Ongkir</button>
</form>

<hr>

<?php
if (isset($_GET['asal']) && isset($_GET['tujuan']) && isset($_GET['muatan'])) {
    $asal = $_GET['asal'];
    $tujuan = $_GET['tujuan'];
    $muatan = floatval($_GET['muatan']);

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mendapatkan tarif per ton berdasarkan asal dan tujuan
    $query1 = "SELECT * FROM (
    SELECT asal, tujuan, tarif_perton FROM tarif
    UNION
    SELECT tujuan AS asal, asal AS tujuan, tarif_perton  AS tarif_perton FROM tarif
) AS t1 WHERE asal = '$asal' AND tujuan = '$tujuan'";

    $result2 = $conn->query($query1);

    if ($result2->num_rows > 0) {
        $row = $result2->fetch_assoc();
        $tarif_perton = $row['tarif_perton'];
        $total_tarif = $tarif_perton * $muatan;

        echo "<h4>Hasil Cek Ongkir:</h4>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Detail</th><th>Nilai</th></tr></thead>";
        echo "<tbody>";
        echo "<tr><td>Dari</td><td>$asal</td></tr>";
        echo "<tr><td>Ke</td><td>$tujuan</td></tr>";
        echo "<tr><td>Muatan (ton)</td><td>$muatan</td></tr>";
        echo "<tr><td>Tarif per ton</td><td>Rp. " . number_format($tarif_perton, 2, ',', '.') . "</td></tr>";
        echo "<tr><td>Total Tarif</td><td>Rp. " . number_format($total_tarif, 2, ',', '.') . "</td></tr>";
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning mt-4'>Tarif untuk rute tersebut tidak ditemukan.</div>";
    }

    // Tutup koneksi database
    $conn->close();
}
?>

</div>

<script>
    // JavaScript untuk mengatur dropdown kota tujuan berdasarkan kota asal yang dipilih
    document.getElementById('asal').addEventListener('change', function() {
        var asal = this.value;
        var tujuanDropdown = document.getElementById('tujuan');

        // Reset pilihan tujuan sebelumnya
        tujuanDropdown.innerHTML = '<option value="">Pilih Kota Tujuan</option>';

        // Jika kota asal dipilih, ambil pilihan kota tujuan yang relevan
        if (asal !== '') {
            // Mengambil data kota tujuan berdasarkan kota asal yang dipilih
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var dataTujuan = JSON.parse(this.responseText);
                    dataTujuan.forEach(function(tujuan) {
                        var option = document.createElement('option');
                        option.value = tujuan;
                        option.textContent = tujuan;
                        tujuanDropdown.appendChild(option);
                    });
                }
            };
            xhttp.open('GET', 'get_tujuan.php?asal=' + asal, true);
            xhttp.send();
        }
    });
</script>