<?php
include 'pages/check_session.php';
include 'pages/db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE id = '$user_id' LIMIT 1";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

$sql1 = "SELECT COUNT(*) AS total_rows FROM pengiriman";
$result1 = $conn->query($sql1);

$sql2 = "SELECT COUNT(*) AS jumlah_data
FROM Pengiriman p
JOIN Client c ON p.client_id = c.client_id
JOIN Gudang g ON p.warehouse_id = g.warehouse_id
JOIN Driver d ON p.driver_id = d.driver_id
WHERE p.realisasi_pengiriman IS NOT NULL 
    AND p.tanggal_bongkar IS NOT NULL 
    AND p.keterlambatan IS NOT NULL;";
$result2 = $conn->query($sql2);

$sql3 = "SELECT COUNT(*) AS total_rows FROM driver";
$result3 = $conn->query($sql3);

$sql4 = "SELECT COUNT(*) AS total_rows FROM client";
$result4 = $conn->query($sql4);





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PT. Cahaya Baru Transindo Utama</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
                </div>
                <div class="sidebar-brand-text mx-1">PT. Cahaya Baru Transindo Utama</div>
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
                        <a class="collapse-item" href="index.php?page=client">Table Data Client</a>
                        <a class="collapse-item" href="index.php?page=tambah_client">Tambah Data Client</a>
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
                        <a class="collapse-item" href="index.php?page=driver">Table Data Driver</a>
                        <a class="collapse-item" href="index.php?page=tambah_driver">Tambah Data Driver</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsetarif" aria-expanded="true" aria-controls="collapsetarif">
                    <i class="fas fa-fw fa-money-bill"></i>
                    <span>Tarif</span>
                </a>
                <div id="collapsetarif" class="collapse" aria-labelledby="headingtarif" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tarif Ongkos Kirim</h6>
                        <a class="collapse-item" href="index.php?page=tarif">Table Data Tarif</a>
                        <a class="collapse-item" href="index.php?page=tambah_tarif">Tambah Data Tarif</a>
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
                        <a class="collapse-item" href="index.php?page=gudang">Table Data Gudang</a>
                        <a class="collapse-item" href="index.php?page=tambah_gudang">Tambah Data Gudang</a>
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
                        <a class="collapse-item" href="index.php?page=pengiriman">Pengiriman Berlangsung</a>
                        <a class="collapse-item" href="index.php?page=pengiriman_selesai">Pengiriman Selesai</a>
                        <a class="collapse-item" href="index.php?page=tambah_pengiriman">Tambah Data Pengiriman</a>
                    </div>
                </div>
            </li>


            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $row["username"] ?></span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
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
                    <?php include 'content.php'; ?>
                </div>
                <!-- End of Page Content -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; PT. Cahaya Baru Transindo Utama</span>
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
                    <a class="btn btn-primary" href="pages/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

</body>

</html>