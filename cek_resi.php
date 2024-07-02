        <h2 class="mb-4">Cek Resi / Status Pengiriman</h2>

        <!-- Form untuk memasukkan nomor resi -->
        <form method="get" action="index.php">
            <input type="text" name="page" value="cek_resi" hidden>
            <div class="form-group">
                <label for="resi">Masukkan Nomor Resi:</label>
                <input type="text" class="form-control" id="resi" name="resi" placeholder="Nomor Resi" required>
            </div>
            <button type="submit" class="btn btn-primary">Cek Status Pengiriman</button>
        </form>

        <hr>

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

        // Ambil nomor resi dari parameter GET
        if (isset($_GET['resi'])) {
            $resi = $_GET['resi'];

            // Query untuk mencari pengiriman sesuai nomor resi
            $query = "SELECT p.pengiriman_id, p.tanggal, c.nama_client, p.muatan, p.jenis_barang, p.target_pengiriman,
                            g.nama_gudang AS asal_gudang, p.tujuan_bongkar, d.plat, p.realisasi_pengiriman,
                            p.tanggal_bongkar, p.keterlambatan, p.harga
                    FROM Pengiriman p
                    JOIN Client c ON p.client_id = c.client_id
                    JOIN Gudang g ON p.warehouse_id = g.warehouse_id
                    JOIN Driver d ON p.driver_id = d.driver_id
                    WHERE p.pengiriman_id = '$resi'
                    AND p.realisasi_pengiriman IS NULL 
                    AND p.tanggal_bongkar IS NULL 
                    AND p.keterlambatan IS NULL";

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // Jika pengiriman ditemukan (sedang dalam proses)
                $row = $result->fetch_assoc();
                echo "<h4>Status Pengiriman untuk Resi $resi:</h4>";
                echo "<p>Sedang dalam proses pengiriman:</p>";
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>Detail Pengiriman</th><th>Nilai</th></tr></thead>";
                echo "<tbody>";
                echo "<tr><td>Tanggal</td><td>" . $row['tanggal'] . "</td></tr>";
                echo "<tr><td>Client</td><td>" . $row['nama_client'] . "</td></tr>";
                echo "<tr><td>Muatan (ton)</td><td>" . $row['muatan'] . "</td></tr>";
                echo "<tr><td>Jenis Barang</td><td>" . $row['jenis_barang'] . "</td></tr>";
                echo "<tr><td>Target Pengiriman</td><td>" . $row['target_pengiriman'] . " Hari</td></tr>";
                echo "<tr><td>Asal Gudang</td><td>" . $row['asal_gudang'] . "</td></tr>";
                echo "<tr><td>Tujuan Bongkar</td><td>" . $row['tujuan_bongkar'] . "</td></tr>";
                echo "<tr><td>Plat</td><td>" . $row['plat'] . "</td></tr>";
                echo "</tbody></table>";
            } else {
                // Jika pengiriman tidak ditemukan (telah sampai ke tujuan)
                $query_sampai_tujuan = "SELECT p.pengiriman_id, p.tanggal, c.nama_client, p.muatan, p.jenis_barang, p.target_pengiriman,
                                            g.nama_gudang AS asal_gudang, p.tujuan_bongkar, d.plat, p.realisasi_pengiriman,
                                            p.tanggal_bongkar, p.keterlambatan, p.harga
                                    FROM Pengiriman p
                                    JOIN Client c ON p.client_id = c.client_id
                                    JOIN Gudang g ON p.warehouse_id = g.warehouse_id
                                    JOIN Driver d ON p.driver_id = d.driver_id
                                    WHERE p.pengiriman_id = '$resi'
                                    AND p.realisasi_pengiriman IS NOT NULL 
                                    AND p.tanggal_bongkar IS NOT NULL 
                                    AND p.keterlambatan IS NOT NULL";

                $result_sampai_tujuan = $conn->query($query_sampai_tujuan);

                if ($result_sampai_tujuan->num_rows > 0) {
                    $row_sampai_tujuan = $result_sampai_tujuan->fetch_assoc();
                    echo "<h4>Status Pengiriman untuk Resi $resi:</h4>";
                    echo "<p>Telah sampai ke tujuan:</p>";
                    echo "<table class='table table-bordered'>";
                    echo "<thead><tr><th>Detail Pengiriman</th><th>Nilai</th></tr></thead>";
                    echo "<tbody>";
                    echo "<tr><td>Tanggal</td><td>" . $row_sampai_tujuan['tanggal'] . "</td></tr>";
                    echo "<tr><td>Client</td><td>" . $row_sampai_tujuan['nama_client'] . "</td></tr>";
                    echo "<tr><td>Muatan (ton)</td><td>" . $row_sampai_tujuan['muatan'] . "</td></tr>";
                    echo "<tr><td>Jenis Barang</td><td>" . $row_sampai_tujuan['jenis_barang'] . "</td></tr>";
                    echo "<tr><td>Target Pengiriman</td><td>" . $row_sampai_tujuan['target_pengiriman'] . " Hari</td></tr>";
                    echo "<tr><td>Asal Gudang</td><td>" . $row_sampai_tujuan['asal_gudang'] . "</td></tr>";
                    echo "<tr><td>Tujuan Bongkar</td><td>" . $row_sampai_tujuan['tujuan_bongkar'] . "</td></tr>";
                    echo "<tr><td>Plat</td><td>" . $row_sampai_tujuan['plat'] . "</td></tr>";
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-warning mt-4'>Resi $resi tidak ditemukan.</div>";
                }
            }

            // Tutup koneksi database
            $conn->close();
        }
        ?>