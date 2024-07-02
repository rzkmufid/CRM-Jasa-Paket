<?php
include 'db.php';
include 'check_session.php';

// Query data pengiriman
$result = mysqli_query($conn, "SELECT
    pengiriman.shipment_id AS 'Id Pengiriman',
    pengiriman.tanggal_bongkar AS 'Tanggal Bongkar',
    pengiriman.jenis_barang AS 'Jenis Barang',
    pengiriman.target_pengiriman AS 'TARGET PENGIRIMAN',
    gudang.nama_gudang AS 'ASAL GUDANG',
    pengiriman.tujuan_bongkar AS 'TUJUAN BONGKAR',
    pengiriman.plat AS 'PLAT',
    driver.nama_supir AS 'SUPIR',
    pengiriman.realisasi_pengiriman AS 'REALISASI PENGIRIMAN',
    pengiriman.keterlambatan AS 'KETERLAMBATAN',
    pengiriman.status_pengiriman AS 'Status'
FROM
    pengiriman
INNER JOIN
    client ON pengiriman.client_id = client.client_id
INNER JOIN
    driver ON pengiriman.driver_id = driver.driver_id
INNER JOIN
    gudang ON pengiriman.asal_gudang_id = gudang.warehouse_id;");

// Inisialisasi array untuk setiap status pengiriman
$tables = array(
    'Belum Berangkat' => '',
    'Dalam Perjalanan' => '',
    'Telah Sampai' => ''
);

// Memproses setiap baris hasil query
while ($row = mysqli_fetch_assoc($result)) {
    // Tambahkan baris data ke tabel yang sesuai berdasarkan status
    $tables[$row['Status']] .= '<tr>
                    <td>' . $row['Id Pengiriman'] . '</td>
                    <td>' . $row['Tanggal Bongkar'] . '</td>
                    <td>' . $row['Jenis Barang'] . '</td>
                    <td>' . $row['TARGET PENGIRIMAN'] . ' Hari</td>
                    <td>' . $row['ASAL GUDANG'] . '</td>
                    <td>' . $row['TUJUAN BONGKAR'] . '</td>
                    <td>' . $row['PLAT'] . '</td>
                    <td>' . $row['SUPIR'] . '</td>
                    <td>' . $row['REALISASI PENGIRIMAN'] . '</td>
                    <td>' . $row['KETERLAMBATAN'] . '</td>
                    <td>' . $row['Status'] . '</td>
                    <td class="hilang">
                        <a href="edit_pengiriman.php?id=' . $row['Id Pengiriman'] . '" class="btn btn-warning">Edit</a>
                        <a href="hapus_pengiriman.php?id=' . $row['Id Pengiriman'] . '" class="btn btn-danger mt-2">Hapus</a>
                    </td>
                </tr>';
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT first_name, last_name FROM users WHERE id = '$user_id' LIMIT 1";
$result1 = $conn->query($sql);

$row1 = $result1->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>
<style>
    @media print {
        .container {
            margin: 0;
        }

        /* Mengatur lebar halaman cetak */
        body {
            width: 100%;
            font-size: 12px;
        }

        /* Mengatur tabel agar memenuhi halaman cetak */
        table {
            width: 100%;
        }

        /* Menghilangkan elemen-elemen lainnya */
        .sidebar {
            display: none;
        }

        .topbar {
            display: none;
        }

        .sticky-footer {
            display: none;
        }

        .scroll-to-top {
            display: none;
        }

        /* Memastikan tabel tercetak dalam satu halaman */
        .card {
            page-break-inside: avoid;
            padding: 0;
            margin: 0;
        }

        .hilang {
            display: none;
        }

        .card-body {
            padding: 0;
            margin: 0;
        }

        .container-fluid {
            margin: 0;
            padding: 0;
        }

    }
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
                </div>
                <div class="sidebar-brand-text mx-1 ">PT. Cahaya Baru Transindo Utama</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

            <!-- Nav Item - Pages Collapse Menu -->


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClient" aria-expanded="true" aria-controls="collapseClient">
                    <i class="fas fa-fw fa-laugh-wink"></i>
                    <span>Client</span>
                </a>
                <div id="collapseClient" class="collapse" aria-labelledby="headingClient" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Content of Client</h6>
                        <a class="collapse-item" href="client.php">Table Data Client</a>
                        <a class="collapse-item" href="tambah_client.php">Tambah Data Client</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Driver Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDriver" aria-expanded="true" aria-controls="collapseDriver">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Driver</span>
                </a>
                <div id="collapseDriver" class="collapse" aria-labelledby="headingDriver" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Driver</h6>
                        <a class="collapse-item" href="driver.php">Table Data Driver</a>
                        <a class="collapse-item" href="tambah_driver.php">Tambah Data Driver</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Gudang Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGudang" aria-expanded="true" aria-controls="collapseGudang">
                    <i class="fas fa-fw fa-warehouse"></i>
                    <span>Gudang</span>
                </a>
                <div id="collapseGudang" class="collapse" aria-labelledby="headingGudang" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gudang</h6>
                        <a class="collapse-item" href="gudang.php">Table Data Gudang</a>
                        <a class="collapse-item" href="tambah_gudang.php">Tambah Data Gudang</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pengiriman Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengiriman" aria-expanded="true" aria-controls="collapsePengiriman">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Pengiriman</span>
                </a>
                <div id="collapsePengiriman" class="collapse" aria-labelledby="headingPengiriman" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Pengiriman</h6>
                        <a class="collapse-item" href="pengiriman.php">Table Data Pengiriman</a>
                        <a class="collapse-item" href="tambah_pengiriman.php">Tambah Data Pengiriman</a>
                        <a class="collapse-item" href="status_pengiriman.php">Status Pengiriman</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Tables -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li> -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <!-- <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div> -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $row1["first_name"] ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Status Pengiriman</h1>
                    <p class="mb-4">Ini adalah data pengiriman yang telah dikelompokkan berdasarkan status pengiriman.
                    </p>
                    <div class=" mb-3">
                        <button class="btn btn-primary hilang" onclick="printAllTables()">Cetak Semua Tabel</button>
                    </div>

                    <!-- DataTales Example -->
                    <?php foreach ($tables as $status => $table) : ?>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><?php echo $status; ?></h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Id Pengiriman</th>
                                                <th>Tanggal Bongkar</th>
                                                <th>Jenis Barang</th>
                                                <th>Target Pengiriman</th>
                                                <th>Asal Gudang</th>
                                                <th>Tujuan Bongkar</th>
                                                <th>Plat</th>
                                                <th>Supir</th>
                                                <th>Realisasi Pengiriman</th>
                                                <th>Keterlambatan</th>
                                                <th>Status</th>
                                                <th class="hilang">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $table; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- DataTales Example -->


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="text-center my-auto">
                        <span>PT. Cahaya Baru Transindo Utama &copy; 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    </script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script>
        function printAllTables() {
            window.print(); // Mencetak halaman
        }
    </script>


</body>

</html>