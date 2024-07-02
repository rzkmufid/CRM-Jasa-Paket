<?php
$page = isset($_GET['page']) ? $_GET['page'] : '';

switch ($page) {
    case 'client':
        include 'pages/client.php';
        break;
    case 'tambah_client':
        include 'pages/tambah_client.php';
        break;
    case 'edit_client':
        include 'pages/edit_client.php';
        break;
    case 'hapus_client':
        include 'pages/hapus_client.php';
        break;
    case 'driver':
        include 'pages/driver.php';
        break;
    case 'tambah_driver':
        include 'pages/tambah_driver.php';
        break;
    case 'edit_driver':
        include 'pages/edit_driver.php';
        break;
    case 'hapus_driver':
        include 'pages/hapus_driver.php';
        break;
    case 'gudang':
        include 'pages/gudang.php';
        break;
    case 'tambah_gudang':
        include 'pages/tambah_gudang.php';
        break;
    case 'hapus_gudang':
        include 'pages/hapus_gudang.php';
        break;
    case 'edit_gudang':
        include 'pages/edit_gudang.php';
        break;
    case 'pengiriman':
        include 'pages/pengiriman.php';
        break;
    case 'edit_pengiriman':
        include 'pages/edit_pengiriman.php';
        break;
    case 'tambah_pengiriman':
        include 'pages/tambah_pengiriman.php';
        break;
    case 'status_pengiriman':
        include 'pages/status_pengiriman.php';
        break;
    case 'hapus_pengiriman':
        include 'pages/hapus_pengiriman.php';
        break;
    case 'proses_pengiriman':
        include 'pages/proses_pengiriman.php';
        break;
    case 'pengiriman_selesai':
        include 'pages/pengiriman_selesai.php';
        break;
    case 'tarif':
        include 'pages/tarif.php';
        break;
    case 'tambah_tarif':
        include 'pages/tambah_tarif.php';
        break;
    default:
        include 'pages/dashboard.php';
        break;
}