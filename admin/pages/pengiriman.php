<?php

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$result = mysqli_query($conn, "SELECT p.pengiriman_id ,p.tanggal, c.nama_client, p.muatan, p.jenis_barang, p.target_pengiriman,
        g.nama_gudang AS asal_gudang, p.tujuan_bongkar, d.plat, p.harga
        FROM Pengiriman p
        JOIN Client c ON p.client_id = c.client_id
        JOIN Gudang g ON p.warehouse_id = g.warehouse_id
        JOIN Driver d ON p.driver_id = d.driver_id
        WHERE p.realisasi_pengiriman IS NULL AND p.tanggal_bongkar IS NULL AND p.keterlambatan IS NULL");
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Pengiriman</h1>
    <p class="mb-4">Data ini akan mengeluarkan data pengiriman yang terdaftar pada sistem ini.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pengiriman</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID / Resi</th>
                            <th>Tanggal</th>
                            <th>Client</th>
                            <th>Muatan</th>
                            <th>Jenis Barang</th>
                            <th>Target Pengiriman</th>
                            <th>Asal Gudang</th>
                            <th>Tujuan Bongkar</th>
                            <th>Plat</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <?php $id = $row["pengiriman_id"]; ?>

                            <td><?= $row["pengiriman_id"]; ?></td>
                            <td><?= $row["tanggal"]; ?></td>
                            <td><?php echo $row["nama_client"]; ?></td>
                            <td><?php echo $row["muatan"]; ?></td>
                            <td><?php echo $row["jenis_barang"]; ?></td>
                            <td><?php echo $row["target_pengiriman"]; ?> Hari</td>
                            <td><?php echo $row["asal_gudang"]; ?></td>
                            <td><?php echo $row["tujuan_bongkar"]; ?></td>
                            <td><?php echo $row["plat"]; ?></td>
                            <td><?php echo $row["harga"]; ?></td>
                            <td><a href="index.php?page=proses_pengiriman&id=<?php echo $row["pengiriman_id"]; ?>"
                                    class="btn btn-success ">
                                    Proses</a>
                                <a href="index.php?page=edit_pengiriman&id=<?php echo $row["pengiriman_id"]; ?>"
                                    class="btn btn-warning ">
                                    Edit</a>
                                <a href="index.php?page=hapus_pengiriman&id=<?php echo $row["pengiriman_id"]; ?>"
                                    class="btn btn-danger ">Hapus</a>
                            </td>
                        </tr>

                        <?php $i++;
                        endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>