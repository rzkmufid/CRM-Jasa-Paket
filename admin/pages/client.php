<?php
$result = mysqli_query($conn, "SELECT * FROM client");

?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Client</h1>
    <p class="mb-4">Data ini akan mengeluarkan data client yang terdaftar pada sistem ini.</p>

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
                            <th>Nama Client</th>
                            <th>Jenis Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <?php $id = $row["client_id"]; ?>
                                <td><?php echo $row["nama_client"]; ?></td>
                                <td><?php echo $row["jenis_barang"]; ?></td>
                                <td><a href="index.php?page=edit_client&id=<?php echo $row["client_id"]; ?>" class="btn btn-warning ">
                                        Edit</a>
                                    <a href="index.php?page=hapus_client&id=<?php echo $row["client_id"]; ?>" class="btn btn-danger ">Hapus</a>
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