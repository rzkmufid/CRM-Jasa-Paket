<?php
$result = mysqli_query($conn, "SELECT * FROM driver");

?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Driver</h1>
    <p class="mb-4">Data ini akan mengeluarkan data driver yang terdaftar pada sistem ini.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Driver</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Driver</th>
                            <th>Alamat Driver</th>
                            <th>PLAT</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <?php $id = $row["driver_id"]; ?>
                                <td><?php echo $row["nama_supir"]; ?></td>
                                <td><?php echo $row["alamat"]; ?></td>
                                <td><?php echo $row["plat"]; ?></td>
                                <td><a href="index.php?page=edit_driver&id=<?php echo $row["driver_id"]; ?>" class="btn btn-warning ">
                                        Edit</a>
                                    <a href="index.php?page=hapus_driver&id=<?php echo $row["driver_id"]; ?>" class="btn btn-danger ">Hapus</a>
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