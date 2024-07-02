<?php
$result = mysqli_query($conn, "SELECT * FROM gudang");

?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Gudang</h1>
    <p class="mb-4">Data ini akan mengeluarkan data driver yang terdaftar pada sistem ini.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Gudang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Gudang</th>
                            <th>Alamat Gudang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <?php $id = $row["warehouse_id"]; ?>
                                <td><?php echo $row["nama_gudang"]; ?></td>
                                <td><?php echo $row["alamat_gudang"]; ?></td>
                                <td><a href="index.php?page=edit_gudang&id=<?php echo $row["warehouse_id"]; ?>" class="btn btn-warning "> Edit</a>
                                    <a href="index.php?page=hapus_gudang&id=<?php echo $row["warehouse_id"]; ?>" class="btn btn-danger ">Hapus</a>
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