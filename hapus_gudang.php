<?php
// session_start();
// if (!isset($_SESSION["login"]) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
//     header("location:../login");
//     exit;
// }

include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM gudang WHERE warehouse_id =$id");
    header("Location: gudang.php");
}
