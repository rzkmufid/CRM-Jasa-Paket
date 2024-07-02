<?php
$result = mysqli_query($conn, "SELECT * FROM tarif");
?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Tarif</h1>
    <p class="mb-4">Data ini akan mengeluarkan data Tarif Pengiriman yang terdaftar pada sistem ini.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Client</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Tarif per Ton</th>
                            <th>Estimasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <?php $id = $row["id_tarif"]; ?>
                                <td><?php echo $row["asal"]; ?></td>
                                <td><?php echo $row["tujuan"]; ?></td>
                                <td><?php echo $row["tarif_perton"]; ?></td>
                                <td><?php echo $row["estimasi"]; ?></td>
                                <td><a href="index.php?page=edit_tarif&id=<?php echo $row["id_tarif"]; ?>" class="btn btn-warning ">
                                        Edit</a>
                                    <a href="index.php?page=hapus_tarif&id=<?php echo $row["id_tarif"]; ?>" class="btn btn-danger ">Hapus</a>
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