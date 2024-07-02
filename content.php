<?php
$page = isset($_GET['page']) ? $_GET['page'] : '';

switch ($page) {
    case 'cek_resi':
        include 'cek_resi.php';
        break;
    case 'cek_ongkir':
        include 'cek_ongkir.php';
        break;
    default:
        include 'dashboard.php';
        break;
}
