<?php
// Ambil parameter tanggal jika disediakan
if (isset($_GET['tanggal'])) {
    $tanggal = $_GET['tanggal'];
    $query_date = "AND YEAR(p.tanggal) = YEAR('$tanggal') AND MONTH(p.tanggal) = MONTH('$tanggal')";
} else {
    $query_date = "";
}

// Ambil parameter bulan dan tahun jika disediakan
if (isset($_GET['bulan']) && isset($_GET['tahun'])) {
    $bulan = $_GET['bulan'];
    $tahun = $_GET['tahun'];
    $query_date_bulan_tahun = "AND YEAR(p.tanggal) = $tahun AND MONTH(p.tanggal) = $bulan";
} else {
    $query_date_bulan_tahun = "";
}

$query = "SELECT p.pengiriman_id ,p.tanggal, c.nama_client, p.muatan, p.jenis_barang, p.target_pengiriman,
        g.nama_gudang AS asal_gudang, p.tujuan_bongkar, d.plat, p.realisasi_pengiriman,
        p.tanggal_bongkar, p.keterlambatan, p.harga
        FROM Pengiriman p
        JOIN Client c ON p.client_id = c.client_id
        JOIN Gudang g ON p.warehouse_id = g.warehouse_id
        JOIN Driver d ON p.driver_id = d.driver_id
        WHERE p.realisasi_pengiriman IS NOT NULL 
        AND p.tanggal_bongkar IS NOT NULL 
        AND p.keterlambatan IS NOT NULL
        $query_date
        $query_date_bulan_tahun
        ORDER BY p.tanggal ASC";

$result = mysqli_query($conn, $query);
?>
<style>
    @media print {

        /* Sembunyikan tombol cetak */
        #btnPrint {
            display: none;
        }

        /* Sembunyikan form filter */
        .filter-form {
            display: none;
        }

        /* Sembunyikan elemen-elemen yang tidak perlu dicetak */
        .disable_print {
            display: none;
        }

        /* Sesuaikan lebar tabel */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .wrapper,
        .navbar-nav,
        .disable_print {
            display: none;
        }

        /* Sembunyikan form filter */
        .filter-form {
            display: none;
        }

        .container-fluid {
            padding: 0;
            margin: 0;
        }
    }
</style>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Pengiriman Selesai</h1>
    <p class="mb-4">Data ini akan mengeluarkan data pengiriman yang telah selesai pada sistem ini.</p>

    <!-- Form Filter -->
    <form method="GET" action="index.php" class="disable_print">
        <input type="hidden" name="page" value="pengiriman_selesai"> <!-- Menyimpan halaman saat ini -->
        <div class="form-row">
            <div class="col-md-3 mb-3">
                <label for="bulan">Bulan</label>
                <select class="form-control" id="bulan" name="bulan">
                    <option value="01" <?php echo ($_GET['bulan'] ?? '') == '01' ? 'selected' : ''; ?>>Januari</option>
                    <option value="02" <?php echo ($_GET['bulan'] ?? '') == '02' ? 'selected' : ''; ?>>Februari</option>
                    <option value="03" <?php echo ($_GET['bulan'] ?? '') == '03' ? 'selected' : ''; ?>>Maret</option>
                    <option value="04" <?php echo ($_GET['bulan'] ?? '') == '04' ? 'selected' : ''; ?>>April</option>
                    <option value="05" <?php echo ($_GET['bulan'] ?? '') == '05' ? 'selected' : ''; ?>>Mei</option>
                    <option value="06" <?php echo ($_GET['bulan'] ?? '') == '06' ? 'selected' : ''; ?>>Juni</option>
                    <option value="07" <?php echo ($_GET['bulan'] ?? '') == '07' ? 'selected' : ''; ?>>Juli</option>
                    <option value="08" <?php echo ($_GET['bulan'] ?? '') == '08' ? 'selected' : ''; ?>>Agustus</option>
                    <option value="09" <?php echo ($_GET['bulan'] ?? '') == '09' ? 'selected' : ''; ?>>September
                    </option>
                    <option value="10" <?php echo ($_GET['bulan'] ?? '') == '10' ? 'selected' : ''; ?>>Oktober</option>
                    <option value="11" <?php echo ($_GET['bulan'] ?? '') == '11' ? 'selected' : ''; ?>>November</option>
                    <option value="12" <?php echo ($_GET['bulan'] ?? '') == '12' ? 'selected' : ''; ?>>Desember</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="tahun">Tahun</label>
                <input type="text" class="form-control" id="tahun" name="tahun" value="<?= $_GET['tahun'] ?? '2024' ?>" placeholder="Masukkan tahun (contoh: 2024)">
            </div>
            <div class="col-md-3 mb-3">
                <label>&nbsp;</label><br>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="index.php?page=pengiriman_selesai" class="btn btn-secondary">Reset Filter</a>
                <!-- Tombol Reset -->
            </div>
        </div>
    </form>

    <!-- Tombol Cetak -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <button id="btnPrint" class="btn btn-success">Cetak</button>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pengiriman Selesai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="disable_print">No</th>
                            <th>ID / Resi</th>
                            <th>Tanggal</th>
                            <th>Client</th>
                            <th>Muatan (ton)</th>
                            <th>Jenis Barang</th>
                            <th>Target Pengiriman</th>
                            <th>Asal Gudang</th>
                            <th>Tujuan Bongkar</th>
                            <th>Plat</th>
                            <th>Realisasi Pengiriman</th>
                            <th>Tanggal Bongkar</th>
                            <th>Keterlambatan</th>
                            <th>Harga</th>
                            <th class="disable_print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $total_pendapatan = 0;
                        $bulan_sebelumnya = null;
                        while ($row = mysqli_fetch_assoc($result)) :
                            $tanggal_data = date('Y-m', strtotime($row['tanggal']));
                            if ($tanggal_data != $bulan_sebelumnya) {
                                // Menampilkan total pendapatan perbulan jika data berubah bulan
                                if ($bulan_sebelumnya !== null) {
                                    echo '<tr>';
                                    echo
                                    '<td class="disable_print"></td>';

                                    echo '<td colspan="11" style="text-align: right;">Total Pendapatan Bulan ' . date('F Y', strtotime($bulan_sebelumnya)) . '</td>';
                                    echo '<td>Rp. ' . number_format($total_pendapatan, 0, ',', '.') . '</td>';
                                    echo
                                    '<td class="disable_print"></td>';

                                    echo '</tr>';
                                }
                                $total_pendapatan = 0;
                                $bulan_sebelumnya = $tanggal_data;
                            }
                        ?>
                            <tr>
                                <td class="disable_print"><?= $i; ?></td>
                                <?php $id = $row["pengiriman_id"]; ?>
                                <td><?= $row["pengiriman_id"]; ?></td>
                                <td><?= $row["tanggal"]; ?></td>
                                <td><?= $row["nama_client"]; ?></td>
                                <td><?= $row["muatan"]; ?></td>
                                <td><?= $row["jenis_barang"]; ?></td>
                                <td><?= $row["target_pengiriman"]; ?> Hari</td>
                                <td><?= $row["asal_gudang"]; ?></td>
                                <td><?= $row["tujuan_bongkar"]; ?></td>
                                <td><?= $row["plat"]; ?></td>
                                <td><?= $row["realisasi_pengiriman"]; ?> Hari</td>
                                <td><?= $row["tanggal_bongkar"]; ?></td>
                                <td><?= $row["keterlambatan"]; ?> Hari</td>
                                <td>Rp. <?= number_format($row["harga"], 0, ',', '.'); ?></td>
                                <td class="disable_print">
                                    <a href="index.php?page=edit_pengiriman&id=<?= $row["pengiriman_id"]; ?>" class="btn btn-warning">Edit</a>
                                    <a href="index.php?page=hapus_pengiriman&id=<?= $row["pengiriman_id"]; ?>" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php
                            $total_pendapatan += $row["harga"];
                            $i++;
                        endwhile;

                        // Menampilkan total pendapatan untuk bulan terakhir
                        if ($bulan_sebelumnya !== null) {
                            echo '<tr>';
                            echo '<td class="disable_print"></td>';
                            echo '<td colspan="11" style="text-align: right;">Total Pendapatan Bulan ' . date('F Y', strtotime($bulan_sebelumnya)) . '</td>';
                            echo '<td>Rp. ' . number_format($total_pendapatan, 0, ',', '.') . '</td>';
                            echo '<td class="disable_print"></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('btnPrint').addEventListener('click', function() {
        window.print();
    });
</script>